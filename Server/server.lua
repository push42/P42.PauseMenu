-----------------------------------------------------------------------------------------------------------------------------------------------------------------

ESX = exports["es_extended"]:getSharedObject()
local oxmysql = exports.oxmysql

playerData = {}

-- Update the User Avatar & fetch it
-- Event to update the avatar URL
RegisterNetEvent("updateAvatar")
AddEventHandler("updateAvatar", function(url)
	local xPlayer = ESX.GetPlayerFromId(source)
	local identifier = xPlayer.getIdentifier()

	-- Extract character-specific part from identifier if needed
	local characterIdentifier = string.match(identifier, "char[0-9]:([^:]+)$")
	if characterIdentifier then
		identifier = "char1:" .. characterIdentifier -- Adjust based on your identifier format
	end

	-- Validate URL (basic check)
	if string.match(url, "^(https?://[%w-_%.%?%.:/%+=&]+)$") then
		-- Update avatar in database
		MySQL.Async.execute("UPDATE users SET avatar = @avatar WHERE identifier = @identifier", {
			["@avatar"] = url,
			["@identifier"] = identifier,
		}, function(affectedRows)
			if affectedRows > 0 then
				print("Avatar updated for player: " .. identifier)

				-- Fetch the updated avatar and send it to the client
				MySQL.Async.fetchScalar("SELECT avatar FROM users WHERE identifier = @identifier", {
					["@identifier"] = identifier,
				}, function(avatar)
					if avatar then
						print("Sending updated avatar to client for " .. identifier .. ": " .. avatar) -- Additional debug print
						TriggerClientEvent("updateUserAvatar", xPlayer.source, avatar)
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
RegisterServerEvent("pausemenu:quit")
AddEventHandler("pausemenu:quit", function()
	DropPlayer(source, "You have left the Server! We hope to see you back soon <3")
end)
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
-- Server callback implementation to get information about the user
ESX.RegisterServerCallback("getServerData", function(source, cb)
	local xPlayer = ESX.GetPlayerFromId(source)

	if xPlayer == nil then
		cb({ error = "Player not yet connected" })
		return
	end

	-- Fetch player's money details
	local bankMoney = xPlayer.getAccount("bank").money
	local cashMoney = xPlayer.getMoney()
	local blackMoney = xPlayer.getAccount("black_money").money

	-- Fetch player's health, stamina, hunger, thirst, and other relevant data
	local playerHealth = GetEntityHealth(GetPlayerPed(-1))

	-- Fetch job details
	local job = xPlayer.getJob()
	local jobGrade = job.grade or "N/A"
	local jobGradeLabel = job.grade_label or "N/A"

	-- Prepare the data
	local data = {
		playerId = source, -- Player's ID
		playerName = xPlayer.getName(),
		playerWCName = xPlayer.getName(),
		playerCount = #GetPlayers(),
		maxPlayers = GetConvarInt("sv_maxclients", 32),
		playerPing = GetPlayerPing(source),
		bankMoney = bankMoney,
		cashMoney = cashMoney,
		blackMoney = blackMoney,
		health = playerHealth,
		jobName = jobGradeLabel,
		userId = source,
		-- Add more data as needed
	}

	cb(data)
end)
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
ESX.RegisterServerCallback("getAllPlayersData", function(source, cb)
	local players = GetPlayers()
	local allPlayersData = {}

	for i = 1, #players, 1 do
		local xPlayer = ESX.GetPlayerFromId(players[i])
		if xPlayer then
			local job = xPlayer.getJob() -- Fetch job details
			local jobGrade = job.grade or "N/A"
			local jobGradeLabel = job.grade_label or "N/A"

			if Config.Development.Debugging then
				console.log("Job Object for Player " .. xPlayer.getName() .. ": " .. json.encode(job)) -- Debugging line
			end

			table.insert(allPlayersData, {
				playerId = players[i],
				playerName = xPlayer.getName(),
				playerWCName = xPlayer.getName(),
				playerPing = GetPlayerPing(players[i]),
				jobName = job.name,
				jobGrade = job.grade, -- Fetch job grade from the job object
				jobGradeLabel = job.grade_label, -- Fetch job grade label from the job object
			})
		end
	end

	cb(allPlayersData)
end)
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
RegisterNetEvent("clientChatMessage")
AddEventHandler("clientChatMessage", function(chatEntry)
	local username = GetPlayerName(source)
	local playerId = source
	local timestamp = os.date("%H:%M:%S")

	if Config.Development.Debugging then
		print(
			"clientChatMessage event triggered by "
				.. username
				.. " (ID: "
				.. playerId
				.. ") with message: "
				.. chatEntry
		)
	end
	-- Get all players
	local players = GetPlayers()

	-- Send the message to all players, including the one who sent it
	for _, player in ipairs(players) do
		TriggerClientEvent("receiveMessage", player, username, playerId, timestamp, chatEntry)
	end
end)

-- Function to log the messages from the Chat if they contain bad words
function logBadChatMessages(playerId, username, chatEntry, timestamp)
	print("Attempting to log chat message for player: " .. username)

	if Config.Database.OxMysql then
		local query = "INSERT INTO p42_chatlog (playerId, username, message, timestamp) VALUES (?, ?, ?, ?)"
		oxmysql.execute(query, { playerId, username, chatEntry, timestamp }, function(result)
			if Config.Development.Debugging then
				print("Chat message logged for player: " .. username)
			end
		end)
	elseif Config.Database.MySQLAsync then
		-- Assuming you have mysql-async installed and configured
		MySQL.Async.execute(
			"INSERT INTO p42_chatlog (playerId, username, message, timestamp) VALUES (@playerId, @username, @message, @timestamp)",
			{
				["@playerId"] = playerId,
				["@username"] = username,
				["@message"] = chatEntry,
				["@timestamp"] = timestamp,
			},
			function(affectedRows)
				-- Handle result or error
			end
		)
	end
end

-- Event to log the messages from the Chat if they contain bad words
RegisterServerEvent("logBadChatMessage")
AddEventHandler("logBadChatMessage", function(payload)
	local playerId = source
	local username = payload.username
	local chatEntry = payload.chatEntry
	local timestamp = os.date("%Y-%m-%d %H:%M:%S")

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
			identifier = "char1:" .. characterIdentifier -- Adjust based on your identifier format
			local query = "UPDATE users SET playtime = playtime + ? WHERE identifier = ?"
			oxmysql:execute(query, { amount, identifier }, function(affectedRows)
				if affectedRows then
					print(
						"\x1b[37m[\x1b[0mPush42\x1b[35m@\x1b[0m\x1bPlaytime\x1b[0m] \x1b[37mPlaytime updated for player:\x1b[0m \x1b[35m"
							.. identifier
							.. "\x1b[0m  \x1b[37m+("
							.. "\x1b[31m1 Credit\x1b[37m)\x1b[0m"
					)
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
			updatePlaytime(playerId, Config.TimerSettings.PlayTime.AddPointsToScore) -- Increment by 1 each minute
			fetchLeaderboardData()
		end
	end
end)
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
-- Fetch leaderboard data
function fetchLeaderboardData()
	oxmysql:execute(
		"SELECT firstname, lastname, avatar, playtime FROM users ORDER BY playtime DESC LIMIT 10",
		{},
		function(result)
			TriggerClientEvent("updateLeaderboard", -1, result)
		end
	)
end

-- You can call this function at regular intervals or trigger it with specific events
Citizen.CreateThread(function()
	while true do
		fetchLeaderboardData()
		Citizen.Wait(Config.TimerSettings.PlayTime.FetchLeaderboard)
	end
end)

-- Event to collect (data) from nui callback
RegisterNetEvent("SendReport")
AddEventHandler("SendReport", function(data)
	-- Extract identifiers from the player
	local ids = ExtractIdentifiers(source)
	-- Create a new report object with the collected data
	local NewReport = {
		playerid = source,
		fname = data.fname,
		lname = data.lname,
		reporttype = data.reporttype,
		subject = data.subject,
		description = data.description,
		discord = "<@" .. ids.discord:gsub("discord:", "") .. ">",
		license = ids.license:gsub("license2:", ""),
	}
	-- Send the report through a webhook
	SendWebhook(NewReport)
end)

-- Function to send (data) through webhook
function SendWebhook(data)
	-- Get the footer text, icon, bot name, and bot logo from the configuration
	local footertext = Config.Discord.BotData.Footer.Text
	local icon = Config.Discord.BotData.Footer.Icon
	local botname = Config.Discord.BotData.Name
	local botlogo = Config.Discord.BotData.Logo

	-- Create the report object with the necessary fields
	local report = {
		{
			["title"] = Config.Discord.EmbedData.TitlePrefix .. data.reporttype,
			["color"] = Config.Discord.Colour,
			["footer"] = {
				["text"] = Config.Discord.BotData.Footer.Text .. " - Reported at: " .. os.date("%Y-%m-%d %H:%M:%S"),
				["icon_url"] = Config.Discord.BotData.Footer.Icon,
			},
			["fields"] = {
				{
					["name"] = Config.Discord.EmbedData.Translation.ReportContent,
					["value"] = Config.Discord.EmbedData.Translation.Subject
						.. data.subject
						.. Config.Discord.EmbedData.Translation.Description
						.. data.description,
					["inline"] = false,
				},
				{
					["name"] = Config.Discord.EmbedData.Translation.ReporterDetails,
					["value"] = Config.Discord.EmbedData.Translation.FirstName
						.. data.fname
						.. Config.Discord.EmbedData.Translation.LastName
						.. data.lname
						.. Config.Discord.EmbedData.Translation.DiscordADD
						.. data.discord,
					["inline"] = true,
				},
				{
					["name"] = Config.Discord.EmbedData.Translation.AdditionalInformation,
					["value"] = Config.Discord.EmbedData.Translation.IngameID
						.. data.playerid
						.. Config.Discord.EmbedData.Translation.FiveMLicense
						.. data.license
						.. "||",
					["inline"] = true,
				},
			},
			["thumbnail"] = {
				["url"] = Config.Discord.EmbedData.ThumbnailURL,
			},
			["author"] = {
				["name"] = Config.Discord.EmbedData.Author.Name,
				["icon_url"] = Config.Discord.EmbedData.Author.IconURL,
			},
		},
	}

	-- Perform the HTTP request to send the report through the webhook
	PerformHttpRequest(
		Config.Discord.Webhook,
		function(err, text, headers) end,
		"POST",
		json.encode({
			username = Config.Discord.BotData.Name,
			embeds = report,
			avatar_url = Config.Discord.BotData.Logo,
		}),
		{ ["Content-Type"] = "application/json" }
	)
end

-- Function to grab identifiers from the player
function ExtractIdentifiers(id)
	-- Initialize the identifiers table
	local identifiers = {
		steam = "",
		ip = "",
		discord = "",
		license = "",
		xbl = "",
		live = "",
	}

	-- Loop through the player's identifiers and assign them to the corresponding fields in the identifiers table
	for i = 0, GetNumPlayerIdentifiers(id) - 1 do
		local playerID = GetPlayerIdentifier(id, i)
		if string.find(playerID, "steam") then
			identifiers.steam = playerID
		elseif string.find(playerID, "ip") then
			identifiers.ip = playerID
		elseif string.find(playerID, "discord") then
			identifiers.discord = playerID
		elseif string.find(playerID, "license") then
			identifiers.license = playerID
		elseif string.find(playerID, "xbl") then
			identifiers.xbl = playerID
		elseif string.find(playerID, "live") then
			identifiers.live = playerID
		end
	end

	-- Return the identifiers table
	return identifiers
end

-- Function to broadcast information about online players to all clients
-- Retrieves player data such as player ID, name, ping, job name, and job grade
-- Triggers a client event to update the player list for all clients
function broadcastOnlinePlayers()
	local players = GetPlayers() -- Get a list of all players
	local allPlayersData = {} -- Table to store player data

	-- Iterate through each player
	for _, playerId in ipairs(players) do
		local xPlayer = ESX.GetPlayerFromId(playerId) -- Get the ESX player object
		if xPlayer then
			local job = xPlayer.getJob() -- Get the player's job information
			table.insert(allPlayersData, {
				playerId = playerId, -- Player ID
				playerName = xPlayer.getName(), -- Player name
				playerPing = GetPlayerPing(playerId), -- Player ping
				jobName = job.name, -- Job name
				jobGrade = job.grade_label, -- Job grade label
				-- Add more data as needed
			})
		end
	end

	-- Trigger a client event to update the player list for all clients
	TriggerClientEvent("updateOnlinePlayers", -1, allPlayersData)
end

-- This function creates a new thread that continuously broadcasts online players and waits for a specified amount of time before repeating.
Citizen.CreateThread(function()
	while true do
		broadcastOnlinePlayers() -- Call your new function
		Citizen.Wait(Config.TimerSettings.PlayTime.FetchOnlinePlayers) -- Adjust timing as needed
	end
end)

RegisterServerEvent("get:playerInfo")
AddEventHandler("get:playerInfo", function()
	local _source = source
	local xPlayer = ESX.GetPlayerFromId(_source)

	if xPlayer then
		local job = xPlayer.getJob()

		-- Fetch all user data in one query
		MySQL.Async.fetchAll(
			"SELECT firstname, lastname, height, sex, dateofbirth, avatar, accounts, `group` FROM users WHERE identifier = @identifier",
			{ ["@identifier"] = xPlayer.identifier },
			function(userInfoResult)
				if userInfoResult[1] then
					local playerData = userInfoResult[1]

					-- Send combined data to client
					TriggerClientEvent("set:playerInfo", _source, {
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
					})
				end
			end
		)
	end
end)
