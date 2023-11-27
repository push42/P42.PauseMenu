-----------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------


ESX = exports["es_extended"]:getSharedObject()

-- Event to update the avatar URL
RegisterNetEvent('updateAvatar')
AddEventHandler('updateAvatar', function(url)
    local xPlayer = ESX.GetPlayerFromId(source)
    local identifier = xPlayer.getIdentifier()

    -- Extract character-specific part from identifier if needed
    local characterIdentifier = string.match(identifier, "char[0-9]:([^:]+)$")
    if characterIdentifier then
        identifier = 'char1:' .. characterIdentifier -- Adjust based on your identifier format
    end

    -- Validate URL (basic check)
    if string.match(url, "^(https?://[%w-_%.%?%.:/%+=&]+)$") then
        -- Update avatar in database
        MySQL.Async.execute('UPDATE users SET avatar = @avatar WHERE identifier = @identifier', {
            ['@avatar'] = url,
            ['@identifier'] = identifier
        }, function(affectedRows)
            if affectedRows > 0 then
                print("Avatar updated for player: " .. identifier)
            else
                print("Failed to update avatar for player: " .. identifier)
            end
        end)
    else
        print("Invalid URL provided.")
    end
end)






-----------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------


RegisterServerEvent('pausemenu:quit')
AddEventHandler('pausemenu:quit', function()
    DropPlayer(source,"You have left the Server! We hope to see you back soon <3")
end)











-----------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------


-- Server callback implementation
ESX.RegisterServerCallback('getServerData', function(source, cb)
    local xPlayer = ESX.GetPlayerFromId(source)

    if xPlayer == nil then
        cb({ error = "Player not yet connected" })
        return
    end

    -- Fetch player's money details
    local bankMoney = xPlayer.getAccount('bank').money
    local cashMoney = xPlayer.getMoney()
    local blackMoney = xPlayer.getAccount('black_money').money

    -- Fetch player's health, stamina, hunger, thirst, and other relevant data
    local playerHealth = GetEntityHealth(GetPlayerPed(-1))

    -- Fetch job details
    local job = xPlayer.getJob()

    -- Prepare the data
    local data = {
        playerId = source, -- Player's ID
        playerName = xPlayer.getName(),
        playerWCName = xPlayer.getName(),
        playerCount = #GetPlayers(),
        maxPlayers = GetConvarInt('sv_maxclients', 32),
        playerPing = GetPlayerPing(source),
        bankMoney = bankMoney,
        cashMoney = cashMoney,
        blackMoney = blackMoney,
        health = playerHealth,
        jobName = job.name,
        userId = source,
        -- Add more data as needed
    }

    cb(data)
end)


ESX.RegisterServerCallback('getAllPlayersData', function(source, cb)
    local players = GetPlayers()
    local allPlayersData = {}

    for i=1, #players, 1 do
        local xPlayer = ESX.GetPlayerFromId(players[i])
        if xPlayer then
            table.insert(allPlayersData, {
                playerId = players[i],
                playerName = xPlayer.getName(),
                playerWCName = xPlayer.getName(),
                playerPing = GetPlayerPing(players[i]),
                jobName = xPlayer.getJob().name
                -- Add more data as needed
            })
        end
    end

    cb(allPlayersData)
end)








RegisterNetEvent('clientChatMessage')
AddEventHandler('clientChatMessage', function(message)
    local username = GetPlayerName(source)
    local playerId = source
    local timestamp = os.date('%H:%M:%S')

    -- Broadcast the message with timestamp to all players
    TriggerClientEvent('receiveMessage', -1, username, playerId, timestamp, message)
end)


-----------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------


local oxmysql = exports.oxmysql

-- Function to update playtime
function updatePlaytime(playerId, amount)
    local identifier = GetPlayerIdentifier(playerId)
    if identifier then
        -- Extract the character-specific identifier part (assuming it's after the last ':')
        local characterIdentifier = string.match(identifier, "([^:]+)$")
        if characterIdentifier then
            identifier = 'char1:' .. characterIdentifier -- Adjust based on your identifier format
            local query = 'UPDATE users SET playtime = playtime + ? WHERE identifier = ?'
            oxmysql:execute(query, { amount, identifier }, function(affectedRows)
                if affectedRows then
                    print("\x1b[37m[\x1b[0mPush42\x1b[35m@\x1b[0m\x1bPlaytime\x1b[0m] \x1b[37mPlaytime updated for player:\x1b[0m \x1b[35m" .. identifier .. "\x1b[0m  \x1b[37m+(" .. "\x1b[31m1 Credit\x1b[37m)\x1b[0m")
                else
                    print("[Push42@Playtime] Playtime update failed for player: " .. identifier)
                end
            end)
        else
            print("Character identifier not found for player ID: " .. playerId)
        end
    else
        print("Identifier not found for player ID: " .. playerId)
    end
end

-- Increment playtime every minute
Citizen.CreateThread(function()
    while true do
        Citizen.Wait(Config.TimerSettings.PlayTime.TimeToAddPoints) -- Wait for one minute
        for _, playerId in ipairs(GetPlayers()) do
            updatePlaytime(playerId, Config.TimerSettings.PlayTime.AddPointsToScore); -- Increment by 1 each minute
            fetchLeaderboardData()
        end
    end
end)


-----------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------


-- Fetch leaderboard data
function fetchLeaderboardData()
    oxmysql:execute('SELECT firstname, lastname, avatar, playtime FROM users ORDER BY playtime DESC LIMIT 10', {}, function(result)
        TriggerClientEvent('updateLeaderboard', -1, result)
    end)
end

-- You can call this function at regular intervals or trigger it with specific events
Citizen.CreateThread(function()
    while true do
        fetchLeaderboardData();
        Citizen.Wait(Config.TimerSettings.PlayTime.FetchLeaderboard)
    end
end)



















-- Event to collect (data) from nui callback
RegisterNetEvent('SendReport')
AddEventHandler('SendReport', function(data)
	local ids = ExtractIdentifiers(source)
	local NewReport = {
		playerid = source,
		fname = data.fname,
        lname = data.lname,
        reporttype = data.reporttype,
		subject = data.subject,
		description = data.description,
		discord = '<@'..ids.discord:gsub('discord:', '')..'>',
        license = ids.license:gsub('license2:', '')
	}
	SendWebhook(NewReport)
end)
-- Function to send (data) through webhook
function SendWebhook(data)
    local footertext = Config.Discord.BotData.Footer.Text
    local icon = Config.Discord.BotData.Footer.Icon
    local botname = Config.Discord.BotData.Name
    local botlogo = Config.Discord.BotData.Logo
    local report = {
        {
            ['title'] = Config.Discord.EmbedData.TitlePrefix .. data.reporttype,
            ['color'] = Config.Discord.Colour,
            ['footer'] = {
                ['text'] = Config.Discord.BotData.Footer.Text .. ' - Reported at: ' .. os.date('%Y-%m-%d %H:%M:%S'),
                ['icon_url'] = Config.Discord.BotData.Footer.Icon,
            },
            ['fields'] = {
                {
                    ['name'] = Config.Discord.EmbedData.Translation.ReportContent,
                    ['value'] = Config.Discord.EmbedData.Translation.Subject .. data.subject ..
                                Config.Discord.EmbedData.Translation.Description .. data.description,
                    ['inline'] = false
                },
                {
                    ['name'] = Config.Discord.EmbedData.Translation.ReporterDetails,
                    ['value'] = Config.Discord.EmbedData.Translation.FirstName .. data.fname ..
                                Config.Discord.EmbedData.Translation.LastName .. data.lname ..
                                Config.Discord.EmbedData.Translation.DiscordADD .. data.discord,
                    ['inline'] = true
                },
                {
                    ['name'] = Config.Discord.EmbedData.Translation.AdditionalInformation,
                    ['value'] = Config.Discord.EmbedData.Translation.IngameID .. data.playerid ..
                                Config.Discord.EmbedData.Translation.FiveMLicense .. data.license .. '||',
                    ['inline'] = true,
                }
                
            },
            ['thumbnail'] = {
                ['url'] = Config.Discord.EmbedData.ThumbnailURL
            },
            ['author'] = {
                ['name'] = Config.Discord.EmbedData.Author.Name,
                ['icon_url'] = Config.Discord.EmbedData.Author.IconURL
            }
        }
    }

    PerformHttpRequest(Config.Discord.Webhook, function(err, text, headers) end, 'POST', json.encode({username = Config.Discord.BotData.Name, embeds = report, avatar_url = Config.Discord.BotData.Logo}), {['Content-Type'] = 'application/json'})
end
-- Function to grab indentifiers
function ExtractIdentifiers(id)
    local identifiers = {
        steam = '',
        ip = '',
        discord = '',
        license = '',
        xbl = '',
        live = ''
    }
    for i = 0, GetNumPlayerIdentifiers(id) - 1 do
        local playerID = GetPlayerIdentifier(id, i)
        if string.find(playerID, 'steam') then
            identifiers.steam = playerID
        elseif string.find(playerID, 'ip') then
            identifiers.ip = playerID
        elseif string.find(playerID, 'discord') then
            identifiers.discord = playerID
        elseif string.find(playerID, 'license') then
            identifiers.license = playerID
        elseif string.find(playerID, 'xbl') then
            identifiers.xbl = playerID
        elseif string.find(playerID, 'live') then
            identifiers.live = playerID
        end
    end
    return identifiers
end






function broadcastOnlinePlayers()
    local players = GetPlayers()
    local allPlayersData = {}

    for _, playerId in ipairs(players) do
        local xPlayer = ESX.GetPlayerFromId(playerId)
        if xPlayer then
            table.insert(allPlayersData, {
                playerId = playerId,
                playerName = xPlayer.getName(),
                playerPing = GetPlayerPing(playerId),
                jobName = xPlayer.getJob().name
                -- Add more data as needed
            })
        end
    end

    -- Trigger a client event to update the player list for all clients
    TriggerClientEvent('updateOnlinePlayers', -1, allPlayersData)
end


Citizen.CreateThread(function()
    while true do
        broadcastOnlinePlayers() -- Call your new function
        Citizen.Wait(Config.TimerSettings.PlayTime.FetchOnlinePlayers) -- Adjust timing as needed
    end
end)
