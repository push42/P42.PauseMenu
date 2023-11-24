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











RegisterServerEvent('pausemenu:quit')
AddEventHandler('pausemenu:quit', function()
    DropPlayer(source,"You have left the Server! We hope to see you back soon <3")
end)



-- Server callback implementation
ESX.RegisterServerCallback('getServerData', function(source, cb)
    local xPlayer = ESX.GetPlayerFromId(source)

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








RegisterNetEvent('clientChatMessage')
AddEventHandler('clientChatMessage', function(message)
    local username = GetPlayerName(source)
    local playerId = source
    local timestamp = os.date('%H:%M:%S')

    -- Broadcast the message with timestamp to all players
    TriggerClientEvent('receiveMessage', -1, username, playerId, timestamp, message)
end)












local oxmysql = exports.oxmysql -- Make sure oxmysql is started before your script

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
                    print("\x1b[37m[\x1b[0mPush42\x1b[35m@\x1b[0m\x1b[33mPlaytime\x1b[0m] \x1b[37mPlaytime updated for player:\x1b[0m \x1b[35m" .. identifier .. "\x1b[0m  \x1b[37m+(" .. "\x1b[31m1 Credit\x1b[37m)\x1b[0m")
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
        Citizen.Wait(6000) -- Wait for one minute
        for _, playerId in ipairs(GetPlayers()) do
            updatePlaytime(playerId, 1) -- Increment by 1 each minute
            fetchLeaderboardData()
        end
    end
end)



-- Fetch leaderboard data
function fetchLeaderboardData()
    oxmysql:execute('SELECT firstname, lastname, avatar, playtime FROM users ORDER BY playtime DESC LIMIT 10', {}, function(result)
        TriggerClientEvent('updateLeaderboard', -1, result)
    end)
end

-- You can call this function at regular intervals or trigger it with specific events
Citizen.CreateThread(function()
    while true do
        fetchLeaderboardData()
        Citizen.Wait(6000) -- Update every minute, adjust as needed
    end
end)







