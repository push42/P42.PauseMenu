local open = false

cachedData = {}

if ESX.IsPlayerLoaded() then
	Citizen.SetTimeout(100, function()
		ESX.PlayerLoaded = true
		ESX.PlayerData = ESX.GetPlayerData()

		Wait(1000)

		TriggerServerEvent("get:playerInfo")
	end)
end

RegisterNetEvent("esx:playerLoaded")
AddEventHandler("esx:playerLoaded", function(playerData, isNew)
	ESX.PlayerLoaded = true
	ESX.PlayerData = playerData

	Wait(1000)

	TriggerServerEvent("loadPlayerInformation")
end)

AddEventHandler("onResourceStart", function(resource)
	if resource == GetCurrentResourceName() then
		SetNuiFocus(false, false)
	end
end)

AddEventHandler("onResourceStop", function(resource)
	if resource == GetCurrentResourceName() then
		print("Stopping resource: " .. resource)
		SetNuiFocus(false, false)
	end
end)

------------------------------------------------------------------------------------------------------------------------------------------------------

RegisterCommand("openSettinggmenu", function()
	OpenPauseMenu()
	TriggerServerEvent("get:playerInfo")
end)

RegisterKeyMapping("openSettinggmenu", "Opens the Pause Menu", "keyboard", "ESCAPE")

function OpenPauseMenu()
	Wait(200)
	if not open and not IsPauseMenuActive() then
		SetNuiFocus(true, true)
		SendNUIMessage({
			action = "show",
		})
		DisableControlAction(0, 1, true) -- LookLeftRight
		DisableControlAction(0, 2, true) -- LookUpDown
		DisableControlAction(0, 106, true) -- VehicleMouseControlOverride
		DisableControlAction(0, 142, true) -- MeleeAttackAlternate
		DisableControlAction(0, 30, true) -- MoveLeftRight
		DisableControlAction(0, 31, true) -- MoveUpDown
		DisableControlAction(0, 21, true) -- disable sprint
		DisableControlAction(0, 24, true) -- disable attack
		DisableControlAction(0, 25, true) -- disable aim
		DisableControlAction(0, 47, true) -- disable weapon
		DisableControlAction(0, 58, true) -- disable weapon
		DisableControlAction(0, 263, true) -- disable melee
		DisableControlAction(0, 264, true) -- disable melee
		DisableControlAction(0, 257, true) -- disable melee
		DisableControlAction(0, 140, true) -- disable melee
		DisableControlAction(0, 141, true) -- disable melee
		DisableControlAction(0, 143, true) -- disable melee
		DisableControlAction(0, 75, true) -- disable exit vehicle
		DisableControlAction(27, 75, true) -- disable exit vehicle
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

RegisterNUICallback("exit", function(data, cb)
	SetNuiFocus(false, false)
	open = false
end)

RegisterNUICallback("SendAction", function(data, cb)
	if data.action == "settings" then
		ActivateFrontendMenu(GetHashKey("FE_MENU_VERSION_LANDING_MENU"), 0, -1)
		SetNuiFocus(false, false)
		open = false
	elseif data.action == "map" then
		ActivateFrontendMenu(GetHashKey("FE_MENU_VERSION_MP_PAUSE"), 0, -1)
		SetNuiFocus(false, false)
		open = false
	elseif data.action == "exit" then
		TriggerServerEvent("pausemenu:quit")
		SetNuiFocus(false, false)
		open = false
	elseif data.action == "keyboard" then
		ActivateFrontendMenu(GetHashKey("FE_MENU_VERSION_LANDING_KEYMAPPING_MENU"), 0, -1)
		SetNuiFocus(false, false)
		open = false
	end
end)

-- Listen for NUI callback from HTML/JS
RegisterNUICallback("getServerData", function(data, cb)
	ESX.TriggerServerCallback("getServerData", function(serverData)
		cb(serverData)
	end)
end)

-- Send a Message to all Clients
RegisterNUICallback("sendMessage", function(data, cb)
	if Config.Development.Debugging then
		print("Sending message to server: " .. data.chatEntry) -- Debug print
	end
	TriggerServerEvent("clientChatMessage", data.chatEntry)
	cb("ok")
end)

-- Now register the event
RegisterNetEvent("receiveMessage")
AddEventHandler("receiveMessage", function(username, id, timestamp, chatEntry)
	if Config.Development.Debugging then
		print("Received message from server: ", username, id, timestamp, chatEntry) -- Debug print
	end
	SendNUIMessage({
		type = "chatMessage",
		username = username,
		id = id,
		timestamp = timestamp,
		chatEntry = chatEntry,
	})
end)

-- Listen to the NUI callback from JavaScript
RegisterNUICallback("logBadChatMessage", function(data, cb)
	if data then
		local chatEntry = data.chatEntry
		local username = GetPlayerName(PlayerId()) -- Or any method to get the username

		-- Trigger the server event with all necessary data
		TriggerServerEvent("logBadChatMessage", { username = username, chatEntry = chatEntry })
	else
		if Config.Development.Debugging then
			print("No data received in logBadChatMessage callback")
		end
	end

	if cb then
		cb("ok")
	end
end)

-- Update Leaderboard
RegisterNetEvent("updateLeaderboard")
AddEventHandler("updateLeaderboard", function(leaderboardData)
	-- Send the data to the NUI (HTML/JS)
	SendNUIMessage({
		type = "updateLeaderboard",
		players = leaderboardData,
	})
end)

-- Function to trigger the server event to update the avatar
function UpdatePlayerAvatar(url)
	TriggerServerEvent("updateAvatar", url)
end

-- Example command to set avatar URL
RegisterCommand("setavatar", function(source, args, rawCommand)
	local avatarUrl = args[1] -- Assuming the first argument is the URL
	if avatarUrl then
		UpdatePlayerAvatar(avatarUrl)
	else
		print("Please provide a valid URL.")
	end
end, false)

-- Update the Avatar (Callback)
RegisterNUICallback("updateAvatar", function(data, cb)
	TriggerServerEvent("updateAvatar", data.url)
	cb("ok")
end)

-- Submit button; submits a report as a discord webhook
RegisterNUICallback("NewReport", function(data)
	local NewReport = {
		fname = data.fname,
		lname = data.lname,
		reporttype = data.reporttype,
		subject = data.subject,
		description = data.description,
	}
	TriggerServerEvent("SendReport", NewReport)
end)

-- Update the User List
-- Function to request all players' data
function requestAllPlayersData()
	ESX.TriggerServerCallback("getAllPlayersData", function(playersData)
		if playersData then
			SendNUIMessage({
				action = "displayPlayers",
				playersData = playersData,
			})
		end
	end)
end

-- Update the Online Players
RegisterNetEvent("updateOnlinePlayers")
AddEventHandler("updateOnlinePlayers", function(allPlayersData)
	SendNUIMessage({
		action = "updateOnlinePlayers",
		players = allPlayersData,
	})
end)

-- Handling the NUI message in the HTML/JS
RegisterNUICallback("requestAllPlayersData", function(data, cb)
	requestAllPlayersData()
	cb("ok")
end)

-- Client-side Lua
RegisterNetEvent("set:playerInfo")
AddEventHandler("set:playerInfo", function(data)
	SendNUIMessage({
		action = "setPlayerInfo",
		playerInfo = data,
	})
end)

RegisterNUICallback("openURL", function(data)
	local url = data.url
	SendNUIMessage({
		action = "openURL",
		url = url,
	})
end)
