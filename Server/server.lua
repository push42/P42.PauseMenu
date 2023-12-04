-----------------------------------------------------------------------------------------------------------------------------------------------------------------
ESX = exports["es_extended"]:getSharedObject()
local oxmysql = exports.oxmysql






playerData = {}


-- Function to get the last day of the current month
local function getLastDayOfMonth()
    local date = os.date("*t")
    -- Set day to zero to roll back to the last day of the previous month
    local lastDayTime = os.time({year=date.year, month=date.month + 1, day=0})
    local lastDay = os.date("*t", lastDayTime).day
    return lastDay
end

-- If a new month is reached, it gets reset, reset all dailyrewards table data.
AddEventHandler('onResourceStart', function(resourceName)
    if (GetCurrentResourceName() ~= resourceName) then
      return
    end

    local date = os.date("*t")
    local currentDay = tonumber(date.day)
    local lastDayOfMonth = getLastDayOfMonth()

    MySQL.Sync.execute('DELETE FROM p42_dailyrewards WHERE day > ' .. lastDayOfMonth)

    if currentDay > lastDayOfMonth then
        return
    end

    MySQL.Sync.execute('DELETE FROM p42_dailyrewards WHERE day = ' .. lastDayOfMonth)

end)





-- Update the User Avatar & fetch it
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

                -- Fetch the updated avatar and send it to the client
                MySQL.Async.fetchScalar('SELECT avatar FROM users WHERE identifier = @identifier', {
                    ['@identifier'] = identifier
                }, function(avatar)
                    if avatar then
                        print("Sending updated avatar to client for " .. identifier .. ": " .. avatar) -- Additional debug print
                        TriggerClientEvent('updateUserAvatar', xPlayer.source, avatar)
                    end
                end)

            else
                print("Failed to update avatar for player: " .. identifier)
            end
        end)
    else
        print("Invalid URL provided.")
    end
end)
-- End of User Avatar
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
-- Exit the Game / Drop Player
RegisterServerEvent('pausemenu:quit')
AddEventHandler('pausemenu:quit', function()
    DropPlayer(source,"You have left the Server! We hope to see you back soon <3")
end)
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
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
ESX.RegisterServerCallback('getAllPlayersData', function(source, cb)
    local players = GetPlayers()
    local allPlayersData = {}

    for i=1, #players, 1 do
        local xPlayer = ESX.GetPlayerFromId(players[i])
        if xPlayer then
            local job = xPlayer.getJob() -- Fetch job details
            local jobGrade = job.grade or 'N/A'
            local jobGradeLabel = job.grade_label or 'N/A'
            console.log('Job Object for Player ' .. xPlayer.getName() .. ': ' .. json.encode(job)) -- Debugging line

           

            table.insert(allPlayersData, {
                playerId = players[i],
                playerName = xPlayer.getName(),
                playerWCName = xPlayer.getName(),
                playerPing = GetPlayerPing(players[i]),
                jobName = job.name,
                jobGrade = job.grade, -- Fetch job grade from the job object
                jobGradeLabel = job.grade_label -- Fetch job grade label from the job object
            })
        end
    end

    cb(allPlayersData)
end)
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
RegisterNetEvent('clientChatMessage')
AddEventHandler('clientChatMessage', function(chatEntry)
    local username = GetPlayerName(source)
    local playerId = source
    local timestamp = os.date('%H:%M:%S')

    print("clientChatMessage event triggered by " .. username .. " (ID: " .. playerId .. ") with message: " .. chatEntry)

    -- Get all players
    local players = GetPlayers()

    -- Send the message to all players, including the one who sent it
    for _, player in ipairs(players) do
        TriggerClientEvent('receiveMessage', player, username, playerId, timestamp, chatEntry)
    end
end)


-- Function to log the messages from the Chat if they contain bad words
function logBadChatMessages(playerId, username, chatEntry, timestamp)
    print("Attempting to log chat message for player: " .. username)

    if Config.Database.OxMysql then
        local query = 'INSERT INTO p42_chatlog (playerId, username, message, timestamp) VALUES (?, ?, ?, ?)'
        oxmysql.execute(query, {playerId, username, chatEntry, timestamp}, function(result)
            print("Chat message logged for player: " .. username)
        end)

    elseif Config.Database.MySQLAsync then
        -- Assuming you have mysql-async installed and configured
        MySQL.Async.execute('INSERT INTO p42_chatlog (playerId, username, message, timestamp) VALUES (@playerId, @username, @message, @timestamp)', {
            ['@playerId'] = playerId, ['@username'] = username, ['@message'] = chatEntry, ['@timestamp'] = timestamp},
            function(affectedRows)
                -- Handle result or error
            end
        )
    end
end


-- Event to log the messages from the Chat if they contain bad words
RegisterServerEvent('logBadChatMessage')
AddEventHandler('logBadChatMessage', function(payload)
    local playerId = source
    local username = payload.username
    local chatEntry = payload.chatEntry
    local timestamp = os.date('%Y-%m-%d %H:%M:%S')

    logBadChatMessages(playerId, username, chatEntry, timestamp)
end)


-----------------------------------------------------------------------------------------------------------------------------------------------------------------

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
        broadcastOnlinePlayers(); -- Call your new function
        Citizen.Wait(Config.TimerSettings.PlayTime.FetchOnlinePlayers) -- Adjust timing as needed
    end
end)




RegisterServerEvent('get:playerInfo')
AddEventHandler('get:playerInfo', function()
    local _source = source
    local xPlayer = ESX.GetPlayerFromId(_source)

    if xPlayer then
        local job = xPlayer.getJob()

        -- Fetch all user data in one query
        MySQL.Async.fetchAll('SELECT firstname, lastname, height, sex, dateofbirth, avatar, accounts, `group` FROM users WHERE identifier = @identifier', 
            {['@identifier'] = xPlayer.identifier}, 
            function(userInfoResult)
                if userInfoResult[1] then
                    local playerData = userInfoResult[1]

                    -- Fetch daily rewards data
                    MySQL.Async.fetchAll('SELECT * FROM p42_dailyrewards WHERE identifier = @identifier', 
                        {['@identifier'] = xPlayer.identifier},
                        function(dailyRewardsResult)
                            -- Check if daily rewards data exists
                            if dailyRewardsResult[1] == nil then
                                local date = os.date("*t")
                                MySQL.Async.execute('INSERT INTO p42_dailyrewards (identifier, name, current_day) VALUES (@identifier, @name, @current_day)',
                                    {
                                        ['@identifier'] = xPlayer.identifier,
                                        ['@name'] = GetPlayerName(_source),
                                        ['@current_day'] = tonumber(date.day)
                                    })
                                
                                playerData['dailyRewards'] = {current_day = tonumber(date.day), day = 1, received = 0, received_hour = nil}
                            else
                                playerData['dailyRewards'] = {current_day = dailyRewardsResult[1].current_day, day = dailyRewardsResult[1].day, received = dailyRewardsResult[1].received, received_hour = dailyRewardsResult[1].received_hour}
                            end

                            -- Send combined data to client
                            TriggerClientEvent('set:playerInfo', _source, {
                                job = job.name,
                                grade = job.grade_label,
                                firstname = playerData.firstname,
                                lastname = playerData.lastname,
                                height = playerData.height,
                                sex = playerData.sex,
                                dateofbirth = playerData.dateofbirth,
                                avatar = playerData.avatar,
                                accounts = playerData.accounts,
                                group = playerData.group,
                                dailyRewards = playerData['dailyRewards']
                            })
                        end)
                end
        end)
    end
end)




Citizen.CreateThread(function()
    while true do

        Citizen.Wait(60000 * Config.ThreadRepeat)
  
        local date = os.date("*t")
        local lastDayOfMonth = getLastDayOfMonth()
        local currentHour, currentDay = tonumber(date.hour), tonumber(date.day)

        for k,v in pairs(ESX.GetPlayers()) do

            if v and playerData[v] then

                local xPlayer = ESX.GetPlayerFromId(v)
                local data = playerData[xPlayer.source]

                if data.received == 1 and data.current_day ~= currentDay then

                    if currentDay < 28 and playerData[xPlayer.source].day + 1 <= lastDayOfMonth then

                        MySQL.Sync.execute('UPDATE p42_dailyrewards SET current_day = @current_day, day = day + 1, received = @received, received_hour = @received_hour WHERE identifier = @identifier', {
                            ["identifier"] = xPlayer.identifier,
                            ["current_day"] = currentDay,
                            ["received"] = 0,
                            ["received_hour"] = nil,
                        }) 
    
                        playerData[xPlayer.source] = {current_day = currentDay, day = playerData[xPlayer.source].day + 1, received = 0, received_hour = nil}
    
                        TriggerClientEvent("refreshData", xPlayer.source)
                    end 
                end
                
                if data.received == 0 and data.current_day ~= currentDay then

                    MySQL.Sync.execute('UPDATE p42_dailyrewards SET current_day = @current_day WHERE identifier = @identifier', {
                        ["identifier"] = xPlayer.identifier,
                        ["current_day"] = currentDay,
                    }) 

                    playerData[xPlayer.source].current_day = currentDay
                end

            end

        end

    end
end)





RegisterServerEvent("claimReward")
AddEventHandler("claimReward", function (week, day)

    local xPlayer = ESX.GetPlayerFromId(source)

    if xPlayer then

        for k,v in pairs(Config.DailyRewards[week]) do

            if v.day == tonumber(day) then

                local type, givenReward, givenAmount = v.dayReward.type, v.dayReward.reward, v.dayReward.amount
            
                time = os.date("*t") 
        
                MySQL.Sync.execute('UPDATE p42_dailyrewards SET received = @received, received_hour = @received_hour WHERE identifier = @identifier', {
                    ["identifier"] = xPlayer.identifier,
                    ["received"] = 1,
                    ["received_hour"] = tonumber(time.hour),
                }) 
        
                playerData[xPlayer.source].received = 1
                playerData[xPlayer.source].received_hour = tonumber(time.hour)
            
                if type  == 'item' then
                    xPlayer.addInventoryItem(givenReward, givenAmount)
            
                elseif type  == 'weapon' then
                    xPlayer.addWeapon(givenReward, givenAmount)
            
                elseif type == 'money' then
                    xPlayer.addMoney(givenAmount)
            
                elseif type == 'black_money' then
                    xPlayer.addAccountMoney('black_money', givenAmount)
            
                elseif type == 'bank' then
                    xPlayer.addAccountMoney('bank', givenAmount)
        
                else
        
                    if Config.RewardPacks[type] then
                        local rewards = Config.RewardPacks[type].rewards
        
                        for k, v in pairs(rewards) do
        
                            if v.type  == 'item' then
                                xPlayer.addInventoryItem(v.name, v.amount)
                        
                            elseif v.type  == 'weapon' then
                                xPlayer.addWeapon(v.name, 0)
                        
                            elseif v.type == 'money' then
                                xPlayer.addMoney(v.amount)
                        
                            elseif v.type == 'black_money' then
                                xPlayer.addAccountMoney('black_money', v.amount)
                        
                            elseif v.type == 'bank' then
                                xPlayer.addAccountMoney('bank', v.amount)
                            end
                        end
                    else
                        print("Tried to buy a non existing reward Type. Make sure {"..type.."} exists in Config.RewardPacks.")
                    end
                end
        
                TriggerClientEvent('openDailyRewards', xPlayer.source)
            
                if Config.MythicNotifyMessage then
                    TriggerClientEvent('mythic_notify:client:SendAlert', xPlayer.source, { type = 'inform', text = _U("rewards_claimed_for_day") .. day})
                else
                    TriggerClientEvent('esx:showNotification', xPlayer.source, _U("rewards_claimed_for_day") .. day)
                end
            end    
        end
        
    end

end)







ESX.RegisterServerCallback("fetchUserInformation", function(source, cb)
    local _source = source

   local xPlayer = ESX.GetPlayerFromId(source)
	 
    if playerData[xPlayer.source] then
        cb(playerData[xPlayer.source])
    else
        cb(nil)
    end

end)




