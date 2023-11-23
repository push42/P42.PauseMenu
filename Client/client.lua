local open = false
RegisterCommand('openSettinggmenu', function()
    OpenPauseMenu()
end)

RegisterKeyMapping('openSettinggmenu', 'Opens the Pause Menu', 'keyboard', 'ESCAPE')



function OpenPauseMenu()
	Wait(200)
    if not open and not IsPauseMenuActive() then
		
        SetNuiFocus(true,true)
        SendNUIMessage({
            action = 'show',
        })
        open = true
    end
end



Citizen.CreateThread(function()
    while true do
        Citizen.Wait(0)
        if IsControlJustPressed(1, 199) then
			OpenPauseMenu()
        end
    end
end)



CreateThread(function()
    while true do 
        SetPauseMenuActive(false) 
        Wait(1)
    end
end)

RegisterNUICallback('exit', function(data, cb)
	SetNuiFocus(false, false)
	open = false
	
end)

RegisterNUICallback('SendAction', function(data, cb)
    if data.action == 'settings' then 
        ActivateFrontendMenu(GetHashKey('FE_MENU_VERSION_LANDING_MENU'),0,-1) 
        SetNuiFocus(false, false)
		open = false

        elseif data.action == 'map' then 
            ActivateFrontendMenu(GetHashKey('FE_MENU_VERSION_MP_PAUSE'),0,-1) 
            SetNuiFocus(false, false)
            open = false

            elseif data.action == 'exit' then 
                TriggerServerEvent("pausemenu:quit")
                SetNuiFocus(false, false)
                open = false

                elseif data.action == 'keyboard' then 
                    ActivateFrontendMenu(GetHashKey('FE_MENU_VERSION_LANDING_KEYMAPPING_MENU'),0,-1) 
                    SetNuiFocus(false, false)
                    open = false             
    end
end)


-- Listen for NUI callback from HTML/JS
RegisterNUICallback('getServerData', function(data, cb)
    ESX.TriggerServerCallback('getServerData', function(serverData)
        cb(serverData)
    end)
end)






RegisterNUICallback('sendMessage', function(data, cb)
    TriggerServerEvent('chatMessage', data.message)
    cb('ok')
end)

RegisterNetEvent('receiveMessage')
AddEventHandler('receiveMessage', function(username, id, timestamp, message)
    SendNUIMessage({
        type = "chatMessage",
        username = username,
        id = id,
        timestamp = timestamp,
        message = message
    })
end)





-- Update Leaderboard
RegisterNetEvent('updateLeaderboard')
AddEventHandler('updateLeaderboard', function(leaderboardData)
    -- Send the data to the NUI (HTML/JS)
    SendNUIMessage({
        type = "updateLeaderboard",
        players = leaderboardData
    })
end)









RegisterNetEvent('esx:setJob')
AddEventHandler('esx:setJob', function(job)
	PlayerData.job = job
	TriggerServerEvent('PauseMenu:setjob',PlayerData.job.name)
end)





-- Function to trigger the server event to update the avatar
function UpdatePlayerAvatar(url)
    TriggerServerEvent('updateAvatar', url)
end

-- Example command to set avatar URL
RegisterCommand('setavatar', function(source, args, rawCommand)
    local avatarUrl = args[1] -- Assuming the first argument is the URL
    if avatarUrl then
        UpdatePlayerAvatar(avatarUrl)
    else
        print("Please provide a valid URL.")
    end
end, false)


RegisterNUICallback('updateAvatar', function(data, cb)
    TriggerServerEvent('updateAvatar', data.url)
    cb('ok')
end)
