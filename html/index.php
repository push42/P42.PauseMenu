<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/9d1f4cdd15.js" crossorigin="anonymous"></script>
    <script src="app.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>Pause-Menu by Push.42</title>
</head>


<div class="fixed left-12 top-4">
    <img id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" class="w-28 h-28 rounded-full cursor-pointer" src="./assets/pxrp.gif" alt="User dropdown">
    <div class="text-center text-sm font-sans font-bold text-purple-300 mb-10">Welcome on PXRP</div>
    <div class="text-center text-sm font-sans text-purple-300 mb-2">Usersettings</div>
    <button id="updateAvatar" class="clock-container absolute text-white text-xs p-0.5 rounded-lg font-medium ml-1">
        <i class="fa-regular fa-image text-purple-400 mr-2 text-xs"></i>Choose Avatar
    </button>
</div>


<body class="container mx-auto bg-zinc-950 bg-opacity-95 text-gray-200 font-sans m-0 relative">
    <!-- Avatar Update Panel -->
    <div id="avatarUpdatePanel" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex justify-center items-center z-50">
        <div class="bg-zinc-900 p-4 rounded-lg shadow-lg w-1/3">
            <h3 class="text-lg font-semibold mb-3"><i class="fa-regular fa-image mr-2 text-xl"></i>CHANGE AVATAR<span class="text-xs ml-8 text-gray-300 font-mono"><i class="fa-solid fa-info text-purple-300 text-sm mr-1"></i>Changing the avatar takes about 5 seconds to refresh</span></h3>
            <input type="text" id="avatarUrlInput" class="border border-gray-300 p-2 w-full rounded-md" placeholder="Enter new avatar URL">
            <div class="flex justify-end space-x-2 mt-2">
                <button id="cancelAvatarUpdate" class="bg-zinc-700 text-white px-4 py-2 rounded-md">Cancel</button>
                <button id="confirmAvatarUpdate" class="bg-purple-400 text-white px-4 py-2 rounded-md">Update</button>
            </div>
        </div>
    </div>
    <!-- Player Username -->
    <div id="welcomeUsername" class="player-stat badge ml-10 mt-4 mb-2 text-sm">
        <i class="fa-solid fa-minus mr-2 text-sm"></i>Welcome back, 
        <span class="stat-value text-sm ml-1"> No User found</span>.
    </div>
    <!-- Clock Container -->
    <div class="clock-container absolute top-0 right-6 flex items-center mb-2">
        <i class="fa-solid fa-clock mr-2 text-lg"></i>
        <span id="current-time" class="text-sm font-semibold"></span>
    </div>
    <script>
        function updateTime() {
            const now = new Date();
            const currentTime = now.toLocaleTimeString();
            document.getElementById('current-time').textContent = currentTime;
        }
    
        setInterval(updateTime, 1000);
        updateTime(); // Initialize clock immediately


        // Javascript for updating the Avatar
        document.getElementById('updateAvatar').addEventListener('click', function() {
        document.getElementById('avatarUpdatePanel').classList.remove('hidden');
        });

        document.getElementById('cancelAvatarUpdate').addEventListener('click', function() {
        document.getElementById('avatarUpdatePanel').classList.add('hidden');
        });

        document.getElementById('confirmAvatarUpdate').addEventListener('click', function() {
            var newAvatarUrl = document.getElementById('avatarUrlInput').value;
            if (newAvatarUrl && /^(https?:\/\/.*\.(?:png|jpg|jpeg|gif))$/i.test(newAvatarUrl)) {
                fetch(`https://${GetParentResourceName()}/updateAvatar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json; charset=UTF-8',
                    },
                    body: JSON.stringify({ url: newAvatarUrl })
                });
                document.getElementById('avatarUpdatePanel').classList.add('hidden');
            } else {
                alert('Please enter a valid image URL.');
            }
        });
    </script>    
    <!-- Navigation Menu at Bottom -->
    <div class="nav-menu fixed bottom-0 left-0 right-0 bg-zinc-900 bg-opacity-95 p-2 flex justify-around items-center shadow-lg">
        <div id="resume" class="nav-item"><i class="fa-solid fa-play mr-2"></i>Resume</div>
        <div id="settings" class="nav-item"><i class="fa-solid fa-gear mr-2"></i>Settings</div>
        <div id="map" class="nav-item"><i class="fa-solid fa-map-location-dot mr-2"></i>Map</div>
        <!-- <div id="info" class="nav-item">Info</div> -->
        <div id="keyboard" class="nav-item"><i class="fa-regular fa-keyboard mr-2"></i>Keyboard</div>
        <div id="help" class="nav-item"><i class="fa-regular fa-circle-question mr-2"></i>Help</div>
        <div id="exit" class="nav-item"><i class="fa-solid fa-door-open mr-2"></i>Exit</div>
    </div>





    <!-- Content Panels -->
    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Main Panel -->
        <div class="md:col-span-2">
            <div class="panel bg-gradient-to-r from-zinc-950 to-zinc-900 bg-opacity-95 p-5 rounded-lg shadow-lg drop-shadow-lg">
                <h2 class="panel-heading uppercase font-black font-mono">
                    <i class="fa-solid fa-thumbtack text-xs mr-2"></i>News / Announcements
                </h2>
                <div class="content">
                    <!-- News Item -->
                    <div class="news-item mb-4">
                        <img src="./assets/santeria2.png" alt="News 1" id="newsImage1" class="newsImage1 rounded-lg shadow-lg h-100 object-cover mb-2">
                        <h3 class="text-lg text-white font-semibold mb-1 uppercase"><i class="fa-solid fa-thumbtack mr-2"></i>YOUR NEWS GO HERE</h3>
                        <p class="text-xs text-gray-300 mb-8 font-thin">Short description for news 1. Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus voluptatem odit vero dicta. Id voluptatem, aspernatur totam numquam voluptate fuga obcaecati. Sed ut perspiciatis minima. Amet quidem aut quis debitis.</p>
                        <div class="tags">
                            <span class="tag text-xs bg-red-500 text-white rounded-full px-2 py-1 mr-1 font-bold"><i class="fa-solid fa-bullhorn mr-2"></i>Announcement</span>
                            <span class="tag text-xs bg-gray-800 text-white rounded-full px-2 py-1 mr-1 font-bold"><i class="fa-solid fa-wrench mr-2"></i>Update</span>
                            <span class="tag text-xs bg-purple-800 text-white rounded-full px-2 py-1 mr-1 font-bold"><i class="fa-solid fa-calendar-check mr-2"></i>Event</span>
                        </div>
                        <a href="#" class="read-more absolute bottom-4 right-2 text-xs bg-zinc-800 text-white rounded-full px-2 py-1"><i class="fa-solid fa-arrow-up-right-from-square mr-2 text-xs"></i>Read more..</a>
                    </div>
                </div>
            </div>
        </div>
        
        

        <div class="panel bg-zinc-900 bg-opacity-95 p-5 rounded-lg shadow-lg drop-shadow-lg">
        <div>
            <h2 class="panel-heading uppercase font-black font-mono">
                <i class="fa-regular fa-circle text-xs mr-2"></i>Server Panel<span class="text-sm absolute right-14 text-gray-300"><i class="fa-brands fa-discord mr-2 mt-1"></i>DSC.GG/YOURSERVER</span>
            </h2>
            <div class="player-stats flex gap-2 justify-center mt-4">
                <!-- User ID Badge -->
                <div id="userId" class="player-stat badge" onclick="copyUserIdToClipboard()">
                    <i class="fa-solid fa-id-card text-purple-400"></i>
                    <span class="stat-value text-xs">ID: --</span>
                </div>                
                <!-- Player Username -->
                <div id="playerUsername" class="player-stat badge">
                    <i class="fa-regular fa-user text-purple-400"></i>
                    <span class="stat-value text-xs">No User found</span>
                </div>
                <!-- Player Ping -->
                <div id="playerPing" class="player-stat badge">
                    <i class="fa-solid fa-signal text-purple-400"></i>
                    <span class="stat-value text-xs">-- ms</span>
                </div>
                <!-- Player Count -->
                <div id="playerCount" class="player-stat badge">
                    <i class="fa-solid fa-users text-purple-400"></i>
                    <span class="stat-value text-xs">--/--</span>
                </div>
            </div>



        <!-- Online Players List -->
        <div class="online-players mt-4 bg-zinc-900 bg-opacity-90 p-5 rounded-lg shadow-inner max-h-60 overflow-y-auto">
            <!-- Detailed User Info Container -->
            <div id="detailedUserInfo" class="absolute top-0 left-0 w-full h-full bg-gray-800 text-white p-6 rounded-lg shadow-2xl opacity-0 transition-opacity duration-500 z-10 hidden">
                <button id="closeUserInfo" class="absolute top-2 right-2 text-gray-300 hover:text-gray-100">
                    <i class="fa fa-times"></i>
                </button>

                <!-- Player Image -->
                <div class="flex items-center mb-6">
                    <img id="up-avatar" src="player-avatar.jpg" alt="Player Image" class="w-20 h-20 rounded-full mr-4 shadow-lg"> <!-- Replace with actual image source -->
                    <h2 id="playerName" class="text-2xl font-bold">John Doe</h2> <!-- Dynamic player name -->
                </div>

                <!-- Info Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-lg">
                    <p id="jobNameDetail" class="info-item">Job: <span class="text-blue-500">Not available</span></p>
                    <p id="jobGradeDetail" class="info-item">Grade: <span class="text-blue-500">Not available</span></p>
                    <p id="heightDetail" class="info-item">Height: <span class="text-blue-500">Not available</span></p>
                    <p id="sexDetail" class="info-item">Sex: <span class="text-blue-500">Not available</span></p>
                    <p id="dobDetail" class="info-item">DOB: <span class="text-blue-500">Not available</span></p>
                    <!-- Add more fields as needed -->
                </div>
            </div>


            <script>
                    // Assuming NUI is set up and this script can communicate with your FiveM resource's client script
                window.addEventListener('message', function(event) {
                    if (event.data.action === 'setPlayerInfo') {
                        var data = event.data.playerInfo;

                        // Update HTML elements with the player's data
                        document.getElementById('playerName').textContent = data.firstname + ' ' + data.lastname;
                        document.getElementById('jobNameDetail').querySelector('span').textContent = data.job;
                        document.getElementById('jobGradeDetail').querySelector('span').textContent = data.grade;
                        document.getElementById('heightDetail').querySelector('span').textContent = data.height;
                        document.getElementById('sexDetail').querySelector('span').textContent = data.sex;
                        document.getElementById('dobDetail').querySelector('span').textContent = data.dateofbirth;
                        document.getElementById('up-avatar').src = data.avatar;

                    }
                });

                document.getElementById('playerUsername').addEventListener('click', function() {
                    var detailedInfo = document.getElementById('detailedUserInfo');
                    detailedInfo.classList.toggle('hidden'); // Toggle visibility
                    detailedInfo.style.opacity = detailedInfo.style.opacity == 0 ? 1 : 0; // Toggle opacity
                });

                document.getElementById('closeUserInfo').addEventListener('click', function() {
                    var detailedInfo = document.getElementById('detailedUserInfo');
                    detailedInfo.classList.add('hidden');
                    detailedInfo.style.opacity = 0;
                });
            </script>

                <h3 class="text-md text-white font-semibold mb-2 relative overflow-hidden uppercase"><i class="fa-solid fa-users mr-2 text-white text-sm"></i>Users <span class="text-purple-400">Online</span>
                    <!-- Animated Line -->
                    <span class="block h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 absolute bottom-0 left-0 right-0 animate-pulse"></span>
                </h3>
                    <ul id="playerList" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Filler Players -->
                        <li class="player-item inline-flex items-center rounded-md bg-zinc-900 px-2 py-1 text-xs font-medium text-purple-700 ring-2 ring-inset ring-gray-600/10">
                            <div class="flex items-center justify-between mb-1">
                                <span class="flex items-center text-white">
                                    Username
                                </span>
                                <span class="text-xs font-mono ml-2 text-purple-400">1</span>
                            </div>
                            <div class="text-xss text-gray-400 text-center uppercase font-bold">
                                Police: <span class="relative font-medium">Officer</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <script>
        $(document).ready(function() {
            window.addEventListener('message', function(event) {
                if (event.data.action === 'updateOnlinePlayers') {
                    updatePlayerList(event.data.players);
                }
            });

            function updatePlayerList(players) {
                $('#playerList').empty();
                players.forEach(player => {
                    $('#playerList').append(createPlayerListItem(player));
                });
            }

            function createPlayerListItem(player) {
                return `
                    <li class="player-item inline-flex items-center rounded-md bg-zinc-900 px-2 py-1 text-xs font-medium text-purple-700 ring-2 ring-inset ring-gray-600/10">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-mono text-purple-400">${player.playerId}</span>
                            <span class="flex items-center ml-1 text-white">${player.playerName}</span>
                            <span class="text-xss font-mono text-green-400 ml-1 mt-2">${player.playerPing}ms</span>
                        </div>
                        <div class="text-xss text-gray-400 text-center uppercase font-bold">
                            ${player.jobName}
                        </div>
                    </li>
                `;
            }
        });
        </script>





        <!-- Panel 1 - Tebex Shop Section -->
        <div class="tebex-shop-panel bg-zinc-900 bg-opacity-90 p-5 rounded-xl shadow-xl transform hover:scale-105 transition duration-300">
            <img src="./assets/tebex-bg.png" alt="Tebex Shop Background" class="tebex-shop-bg">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-lg text-green-400">
                        <i class="fa-solid fa-shopping-cart text-sm mr-2"></i>Visit <span class="text-green-400">our</span> Store.
                    </h2>
                    <h2>
                        <span class="donate-text font-sans font-medium">Looking for a way to support the Project?</span>
                    </h2>
                </div>
                <img src="./assets/tebex_shop.jpg" alt="Tebex Shop" class="rounded-full w-10 h-10">
            </div>            
            <p class="text-sm text-gray-300 mt-4">
                Check out exclusive items and special offers available in our Tebex Shop. Lorem ipsum dolor sit amet consectetur adipisicing elit.
            </p>
            <ul class="grid w-full gap-2 md:grid-cols-1 absolute bottom-0 right-0">
                <li>
                    <input type="radio" id="hosting-small" name="hosting" value="hosting-small" class="hidden peer" required="">
                    <label for="hosting-small" class="scur inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white rounded-lg cursor-pointer dark:hover:text-gray-300 dark:peer-checked:text-green-400 peer-checked:text-green-400 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-zinc-900 dark:hover:bg-gray-700">                           
                        <div class="block">
                            <img class="w-10 h-10 rounded-full mx-auto absolute" src="./assets/animated-lp.webp">
                            <div class="w-full text-sm font-semibold ml-12">Lorazepam</div>
                            <div class="w-full text-xs ml-12"><i class="fa-solid fa-tags mr-1"></i>Your Product<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2 py-0 rounded-full dark:bg-green-900 dark:text-green-300 ml-2">$24.99</span></div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><style>svg{fill:#ffffff}</style>
                            <path d="M160 112c0-35.3 28.7-64 64-64s64 28.7 64 64v48H160V112zm-48 48H48c-26.5 0-48 21.5-48 48V416c0 53 43 96 96 96H352c53 0 96-43 96-96V208c0-26.5-21.5-48-48-48H336V112C336 50.1 285.9 0 224 0S112 50.1 112 112v48zm24 48a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm152 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"/>
                        </svg>
                    </label>
                </li>
            </ul>
        </div>






        <!-- Panel 2 - Get Support Section -->
        <div class="get-support-panel bg-zinc-900 bg-opacity-90 p-5 rounded-xl shadow-xl transform hover:scale-105 transition duration-300">
            <img src="./assets/get_support.png" alt="Tebex Shop Background" class="tebex-shop-bg">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-lg text-blue-400">
                    <i class="fa-solid fa-headset text-sm mr-2 text-white"></i>Need <span class="text-white">Assistance?</span>
                </h2>
                <img src="./assets/discord_logo.webp" alt="Discord Logo" class="rounded-full w-16 h-16">
            </div>
            <p class="text-sm text-gray-100 mt-4">
                Our dedicated support team is here to assist you. Feel free to reach out with any queries or concerns. Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate, sapiente.
            </p>
            <button type="button" class="inline-flex items-center px-3 py-1.5 text-sm font-bold text-center text-white bg-zinc-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-zinc-800 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <i class="fa-solid fa-ticket mr-2 text-blue-400"></i>Live Support
            </button>    
            <button id="discord-btn" type="button" onclick="copyDiscordLink()" class="inline-flex items-center px-3 py-1.5 text-sm font-bold text-center text-white bg-zinc-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-zinc-800 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ml-2 mt-7">
                <i class="fa-brands fa-discord mr-2 text-blue-400"></i>Discord
            </button>
        </div>

        <script>
            function showNotificationModal(title, message) {
                document.getElementById('notification-title').innerText = title;
                document.getElementById('notification-message').innerText = message;
                document.getElementById('notification-modal').classList.remove('hidden');
            }

            function closeNotificationModal() {
                document.getElementById('notification-modal').classList.add('hidden');
            }

            function copyDiscordLink() {
                const discordInvite = "https://discord.com/invite/yourserver"; // Replace with your Discord invite link
                showNotificationModal("Discord Invite", `Copy the Discord invite link: ${discordInvite}`);
            }
        </script>


        <div id="notification-modal" class="hidden fixed inset-0 bg-zinc-900 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
            <div class="bg-zinc-900 rounded-lg shadow-xl p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                    <h2 id="notification-title" class="text-xl font-semibold text-white">Notification Title</h2>
                    <button onclick="closeNotificationModal()" class="text-gray-300 hover:text-gray-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p id="notification-message" class="text-gray-300 mb-6">Your notification message goes here.</p>
                <button onclick="closeNotificationModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    OK
                </button>
            </div>
        </div>




        <!-- Panel 3 - Global Leaderboard -->
        <!-- Leaderboard Panel -->
        <div class="leaderboard-panel bg-zinc-950 bg-opacity-50 p-4 rounded-xl shadow-xl overflow-y-auto max-h-64">
        <!-- Avatar Update Button -->
            <h2 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fa-solid fa-trophy mr-2"></i>
                Leaderboard<span class="text-xs font-thin ml-4">Only the first 10 with the most Playtime are displayed.</span>
            </h2>
            <ul class="space-y-2">
                <!-- Leaderboard Item -->
                <li class="flex items-center justify-between bg-gradient-to-r from-zinc-950 to-zinc-900 bg-opacity-95 p-2 rounded-lg">
                    <div class="flex items-center">
                        <img src="./assets/pxrp.gif" alt="Player 1" class="w-8 h-8 rounded-full mr-2">
                        <span class="text-white text-sm">Player 1</span><i class="fa-solid fa-trophy fa-beat fa-xs ml-4" style="color: #ffff80;"></i>
                    </div>
                    <span class="badge bg-gray-800 text-white text-xs px-2 py-1 rounded-full font-bold shadow-lg">Score: 1500</span>
                </li>
                <!-- Repeat for other players -->
                <li class="flex items-center justify-between bg-gradient-to-r from-zinc-950 to-zinc-900 bg-opacity-95 p-2 rounded-lg">
                    <div class="flex items-center">
                        <img src="https://i.ibb.co/CwByvYM/empress-purple.webp" alt="Player 1" class="w-8 h-8 rounded-full mr-2">
                        <span class="text-white text-sm">Player 2</span><i class="fa-solid fa-trophy fa-beat fa-xs ml-4" style="color: #c9c9c9;"></i>
                    </div>
                    <span class="badge bg-gray-800 text-white text-xs px-2 py-1 rounded-full font-bold shadow-lg">Score: 1330</span>
                </li>
                <li class="flex items-center justify-between bg-gradient-to-r from-zinc-950 to-zinc-900 bg-opacity-95 p-2 rounded-lg">
                    <div class="flex items-center">
                        <img src="https://i.ibb.co/r4KmhTG/animated-lp.webp" alt="Player 1" class="w-8 h-8 rounded-full mr-2">
                        <span class="text-white text-sm">Player 3</span><i class="fa-solid fa-trophy fa-beat fa-xs ml-4" style="color: #b87536;"></i>
                    </div>
                    <span class="badge bg-gray-800 text-white text-xs px-2 py-1 rounded-full font-bold shadow-lg">Score: 755</span>
                </li>
                <li class="flex items-center justify-between bg-gradient-to-r from-zinc-950 to-zinc-900 bg-opacity-95 p-2 rounded-lg">
                    <div class="flex items-center">
                        <img src="https://i.ibb.co/r4KmhTG/animated-lp.webp" alt="Player 1" class="w-8 h-8 rounded-full mr-2">
                        <span class="text-white text-sm">Player 3</span><i class="fa-solid fa-trophy fa-beat fa-xs ml-4" style="color: #b87536;"></i>
                    </div>
                    <span class="badge bg-gray-800 text-white text-xs px-2 py-1 rounded-full font-bold shadow-lg">Score: 755</span>
                </li>
            </ul>
        </div>
        <script>
        window.addEventListener('message', function(event) {
            var item = event.data;
            if (item.type === "updateLeaderboard") {
                var leaderboardList = document.querySelector('.leaderboard-panel ul');
                leaderboardList.innerHTML = ''; // Clear existing list
                item.players.forEach(function(player, index) {
                    var playerElement = document.createElement('li');
                    playerElement.className = 'flex items-center justify-between bg-gradient-to-r from-zinc-950 to-zinc-900 bg-opacity-95 p-2 rounded-lg';

                    var trophyIcon = '';
                    if (index === 0) { // First place
                        trophyIcon = '<i class="fa-solid fa-trophy" style="color: gold;"></i>';
                    } else if (index === 1) { // Second place
                        trophyIcon = '<i class="fa-solid fa-trophy" style="color: silver;"></i>';
                    } else if (index === 2) { // Third place
                        trophyIcon = '<i class="fa-solid fa-trophy" style="color: #cd7f32;"></i>'; // Bronze color
                    }

                    playerElement.innerHTML = `
                        <div class="flex items-center">
                            <img src="${player.avatar}" alt="${player.firstname}" class="w-8 h-8 rounded-full mr-2">
                            ${trophyIcon}
                            <span class="text-white text-sm">${player.firstname} ${player.lastname}</span>
                        </div>
                        <span class="badge bg-gray-800 text-white text-xs px-2 py-1 rounded-full font-bold shadow-lg">Score: ${player.playtime}</span>`;
                    leaderboardList.appendChild(playerElement);
                });
            }
        });
        </script>


<!-- Modal Container for Player Reports (Hidden initially) -->
<div id="modal-container" class="hidden fixed inset-0 bg-zinc-950 bg-opacity-30 overflow-y-auto h-full w-full flex justify-center items-center" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Modal Content -->
    <div class="relative top-0 mx-auto p-7 border-2 w-full md:w-1/2 lg:w-1/3 shadow-xl rounded-lg bg-zinc-900 space-y-4">
        <!-- Form Title -->
        <h2 class="text-2xl font-semibold text-white uppercase"><i class="fa-solid fa-user-large-slash text-purple-300 mr-2"></i>Report a Player</h2>

        <!-- Form Container -->
        <div class="form-container space-y-3">
            <!-- Form Fields -->
            <input type="text" id="fname" placeholder="First Name" class="w-full px-4 py-2 border rounded-md focus:border-purple-500 focus:outline-none bg-zinc-800 text-white">
            <input type="text" id="lname" placeholder="Last Name" class="w-full px-4 py-2 border rounded-md focus:border-purple-500 focus:outline-none bg-zinc-800 text-white">
            <select id="reporttype" class="text-gray-300 w-full px-4 py-2 border rounded-md focus:border-purple-500 focus:outline-none bg-zinc-800">
                <option value="PlayerReport">Player Report</option>
                <!-- Add more options as needed -->
            </select>
            <input type="text" id="subject" placeholder="Subject" class="w-full px-4 py-2 border rounded-md focus:border-purple-500 focus:outline-none bg-zinc-800 text-white">
            <textarea id="description" placeholder="Description" class="w-full h-32 px-4 py-2 border rounded-md focus:border-purple-500 focus:outline-none bg-zinc-800 text-white"></textarea>

            <!-- Submit Button -->
            <button id="form-submit-btn" class="w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                Submit Report
            </button>
        </div>
        <!-- Close Button -->
        <button id="close-modal-btn" class="bg-zinc-800 hover:bg-zinc-700 text-red-500 font-bold py-2 px-4 rounded absolute top-1 right-6 transition duration-200">
            Close<i class="fa-solid fa-xmark ml-2"></i>
        </button>
    </div>
</div>








<!-- Panel 3 - Detailed Info Panel -->
<div class="panel bg-zinc-900 bg-opacity-90 p-2 rounded-lg shadow-lg col-span-1">
    <!-- Advent Calendar Panel -->
    <div class="bg-zinc-900 bg-opacity-90 p-4 rounded-lg">
        <h2 class="font-semibold text-lg text-white mb-4 panel-heading">
            <i class="fa-solid fa-bug mr-1 text-purple-400"></i>
            Report<span class="text-purple-400"> Panel</span>
            <span class="text-xs font-medium ml-4 font-sans">This is a sample text and will soon be replaced.</span>
        </h2>
        <div class="calendar-row flex overflow-x-auto pb-2">
            <!-- Report Cards -->
            <!-- Adding hover effect and gradient background to each report card -->
            <div class="reports bg-gradient-to-r from-zinc-950 to-zinc-900 rounded-lg shadow-lg mr-4 ml-2 flex-none hover:scale-105 transition-transform" onclick="openModal()">
                <div class="day-header bg-zinc-950 text-white text-center py-1.5 rounded-t-lg font-bold text-xss">
                    Report Player
                </div>
                <div class="day-content flex items-center justify-center p-4 h-14">
                    <img src="./assets/player_report.png" alt="Player Report" class="h-42">
                </div>
            </div>
            <!-- Repeat for other report cards with respective content -->
            <!-- ... other report cards ... -->
            <div class="reports bg-gradient-to-r from-zinc-950 to-zinc-900 rounded-lg shadow-lg mr-4 ml-2 flex-none hover:scale-105 transition-transform">
                <div class="day-header bg-zinc-950 text-white text-center py-1.5 rounded-t-lg font-bold text-xss">
                    Report Bugs
                </div>
                <div class="day-content flex items-center justify-center p-4 h-14">
                    <img src="./assets/bug_report.png" alt="Bug Report" class="h-42">
                </div>
            </div>
            <div class="reports bg-gradient-to-r from-zinc-950 to-zinc-900 rounded-lg shadow-lg mr-4 ml-2 flex-none hover:scale-105 transition-transform">
                <div class="day-header bg-zinc-950 text-white text-center py-1.5 rounded-t-lg font-bold text-xss">
                    Report Staff
                </div>
                <div class="day-content flex items-center justify-center p-4 h-14">
                    <img src="./assets/staff_report.png" alt="Player Staff" class="h-42">
                </div>
            </div>
            <div class="reports bg-gradient-to-r from-zinc-950 to-zinc-900 rounded-lg shadow-lg mr-4 ml-2 flex-none hover:scale-105 transition-transform">
                <div class="day-header bg-zinc-950 text-white text-center py-1.5 rounded-t-lg font-bold text-xss">
                    Report Lost Items
                </div>
                <div class="day-content flex items-center justify-center p-4 h-14">
                    <img src="./assets/lost_items.png" alt="Player Staff" class="h-42">
                </div>
            </div>
        </div>
    </div>
</div>



        <!-- Panel 4 - Detailed Info Panel -->
        <div class="panel bg-zinc-900 bg-opacity-90 p-2 rounded-lg shadow-lg col-span-1">
            <!-- Advent Calendar Panel -->
            <div class="advent-calendar-panel bg-zinc-900 bg-opacity-90 p-4 rounded-lg">
                <h2 class="font-semibold text-lg text-white mb-4 panel-heading"><i class="fa-solid fa-calendar-day mr-2 text-purple-400"></i>Daily<span class="text-purple-400"> Rewards</span><span class="text-xs font-medium ml-4 font-sans">This is a sample text and will soon be replaced.</span></h2>
                <div class="calendar-row flex overflow-x-auto pb-2">
                    <!-- Calendar Days -->
                    <div class="calender-door bg-gradient-to-r from-zinc-950 to-zinc-900 rounded-lg shadow-lg mr-4 ml-2 flex-none hover:scale-105 transition-transform opened">
                        <div class="day-header bg-zinc-950 text-white text-center py-1.5 rounded-t-lg font-bold text-xs">
                            DAY 1
                        </div>
                        <div class="day-content flex items-center justify-center p-4 h-14">
                            <img src="./assets/door_badge.webp" alt="Player Report" class="h-42">
                            <!-- Opened Icon -->
                            <div class="open-icon absolute top-3 right-0 transform -translate-x-1/2 -translate-y-1/2">
                                <i class="fa-solid fa-box-open text-white text-xs"></i> <!-- Replace with your lock icon -->
                            </div>
                        </div>
                    </div>
                    <!-- Calendar Days -->
                    <div class="calender-door bg-gradient-to-r from-zinc-950 to-zinc-900 rounded-lg shadow-lg mr-4 flex-none hover:scale-105 transition-transform obtainable">
                        <div class="day-header bg-zinc-950 text-white text-center py-1.5 rounded-t-lg font-bold text-xs">
                            DAY 2
                        </div>
                        <div class="day-content flex items-center justify-center p-4 h-14">
                            <img src="./assets/door_badge.webp" alt="Player Report" class="h-42">
                        </div>
                    </div>
                    <!-- Calendar Days -->
                    <div class="calender-door bg-gradient-to-r from-zinc-950 to-zinc-900 rounded-lg shadow-lg mr-4 flex-none hover:scale-105 transition-transform locked relative">
                        <div class="day-header bg-zinc-950 text-white text-center py-1.5 rounded-t-lg font-bold text-xs">
                            DAY 3
                        </div>
                        <div class="day-content flex items-center justify-center p-4 h-14">
                            <img src="./assets/door_badge.webp" alt="Player Report" class="h-42">
                            <!-- Lock Icon -->
                            <div class="lock-icon absolute top-3 right-0 transform -translate-x-1/2 -translate-y-1/2">
                                <i class="fa-solid fa-lock text-white text-lm"></i> <!-- Replace with your lock icon -->
                            </div>
                        </div>
                    </div>

                    <!-- Calendar Days -->
                    <div class="calender-door bg-gradient-to-r from-zinc-950 to-zinc-900 rounded-lg shadow-lg mr-4 flex-none hover:scale-105 transition-transform locked relative">
                        <div class="day-header bg-zinc-950 text-white text-center py-1.5 rounded-t-lg font-bold text-xs">
                            DAY 4
                        </div>
                        <div class="day-content flex items-center justify-center p-4 h-14">
                            <img src="./assets/door_badge.webp" alt="Player Report" class="h-42">
                            <!-- Lock Icon -->
                            <div class="lock-icon absolute top-3 right-0 transform -translate-x-1/2 -translate-y-1/2">
                                <i class="fa-solid fa-lock text-white text-lm"></i> <!-- Replace with your lock icon -->
                            </div>
                        </div>
                    </div>
                    <!-- Calendar Days -->
                    <div class="calender-door bg-gradient-to-r from-zinc-950 to-zinc-900 rounded-lg shadow-lg mr-4 flex-none hover:scale-105 transition-transform locked relative">
                        <div class="day-header bg-zinc-950 text-white text-center py-1.5 rounded-t-lg font-bold text-xs">
                            DAY 5
                        </div>
                        <div class="day-content flex items-center justify-center p-4 h-14">
                            <img src="./assets/door_badge.webp" alt="Player Report" class="h-42">
                            <!-- Lock Icon -->
                            <div class="lock-icon absolute top-3 right-0 transform -translate-x-1/2 -translate-y-1/2">
                                <i class="fa-solid fa-lock text-white text-lm"></i> <!-- Replace with your lock icon -->
                            </div>
                        </div>
                    </div>
                    <!-- Calendar Days -->
                    <div class="calender-door bg-gradient-to-r from-zinc-950 to-zinc-900 rounded-lg shadow-lg mr-4 flex-none hover:scale-105 transition-transform locked relative">
                        <div class="day-header bg-zinc-950 text-white text-center py-1.5 rounded-t-lg font-bold text-xs">
                            DAY 6
                        </div>
                        <div class="day-content flex items-center justify-center p-4 h-14">
                            <img src="./assets/door_badge.webp" alt="Player Report" class="h-42">
                            <!-- Lock Icon -->
                            <div class="lock-icon absolute top-3 right-0 transform -translate-x-1/2 -translate-y-1/2">
                                <i class="fa-solid fa-lock text-white text-lm"></i> <!-- Replace with your lock icon -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<script>

    
function openModal() {
    document.getElementById('modal-container').classList.remove('hidden');
    document.querySelector('body').classList.add('modal-open');
}

function closeModal() {
    document.getElementById('modal-container').classList.add('hidden');
    document.querySelector('body').classList.remove('modal-open');
}

// Event listener for the close button
document.getElementById('close-modal-btn').addEventListener('click', closeModal);
</script>


<!-- Chatbox Panel -->
<div class="chatbox-panel bg-zinc-900 bg-opacity-90 p-5 rounded-xl shadow-xl">
    <h2 class="text-lg font-semibold text-white mb-4"><i class="fa-regular fa-comments mr-2"></i>Community Chat</h2>
    <div class="chat-messages overflow-y-auto max-h-150 pt-10 pb-6">
        <!-- Chat messages will be dynamically inserted here -->
    </div>
    <form id="chat-form" class="flex items-center">
        <button type="button" id="emoji-button" class="emoji2-btn badge mr-2">😀</button>
        <input type="text" id="chat-input" class="bg-zinc-800 text-white p-1.5 rounded-lg w-full" placeholder="Type a message...">
        <button type="submit" class="bg-purple-400 text-white p-1.5 rounded-lg font-bold">Send</button>

        <div id="emoji-picker" class="emoji-picker hidden absolute bg-zinc-900 bg-opacity-90 p-2 border border-gray-300 rounded-lg bottom-28 right-80">
            <div class="p-2">
                <h3 class="text-white text-lg font-semibold mb-2">Choose an Emoji</h3>
                <div class="emoji-grid">
                <button class="emoji-btn">🤯</button>
                <button class="emoji-btn">🥳</button>
                <button class="emoji-btn">😎</button>
                <button class="emoji-btn">🤓</button>
                <button class="emoji-btn">🧐</button>
                <button class="emoji-btn">😕</button>
                <button class="emoji-btn">😟</button>
                <button class="emoji-btn">🙁</button>
                <button class="emoji-btn">☹️</button>
                <button class="emoji-btn">😮</button>
                <button class="emoji-btn">😯</button>
                <button class="emoji-btn">😲</button>
                <button class="emoji-btn">😳</button>
                <button class="emoji-btn">🥺</button>
                <button class="emoji-btn">😦</button>
                <button class="emoji-btn">😧</button>
                <button class="emoji-btn">😨</button>
                <button class="emoji-btn">😰</button>
                <button class="emoji-btn">😥</button>
                <button class="emoji-btn">😢</button>
                <button class="emoji-btn">😭</button>
                <button class="emoji-btn">😱</button>
                <button class="emoji-btn">😖</button>
                <button class="emoji-btn">😣</button>
                <button class="emoji-btn">😞</button>
                <button class="emoji-btn">😓</button>
                <button class="emoji-btn">😩</button>
                <button class="emoji-btn">😫</button>
                <button class="emoji-btn">🥱</button>
                <button class="emoji-btn">😤</button>
                <button class="emoji-btn">😡</button>
                <button class="emoji-btn">😠</button>
                <button class="emoji-btn">🤬</button>
                <button class="emoji-btn">😈</button>
                <button class="emoji-btn">👿</button>
                <button class="emoji-btn">💀</button>
                <button class="emoji-btn">☠️</button>
                <button class="emoji-btn">💩</button>
                <button class="emoji-btn">🤡</button>
                <button class="emoji-btn">👹</button>
                <button class="emoji-btn">👺</button>
                <button class="emoji-btn">👻</button>
                <button class="emoji-btn">👽</button>
                <button class="emoji-btn">👾</button>
                <button class="emoji-btn">🤖</button>
                <button class="emoji-btn">😺</button>
                <button class="emoji-btn">😸</button>
                <button class="emoji-btn">😹</button>
                <button class="emoji-btn">😻</button>
                <button class="emoji-btn">😼</button>
                <button class="emoji-btn">😽</button>
                <button class="emoji-btn">🙀</button>
                <button class="emoji-btn">😿</button>
                <button class="emoji-btn">😾</button>
                <button class="emoji-btn">🙈</button>
            </div>
        </div>
    </form>
</div>


<script>
// Sending a message to the Lua script
document.getElementById('chat-form').addEventListener('submit', function(event) {
    event.preventDefault();
    var message = this.querySelector('input[type="text"]').value;
    if (message) {
        // Send the message to the Lua client script
        fetch(`https://${GetParentResourceName()}/sendMessage`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=UTF-8',
            },
            body: JSON.stringify({ message: message })
        }).then(() => this.reset());
    }
});
// Receiving messages from the Lua script
window.addEventListener('message', function(event) {
    var item = event.data;
    if (item.type === "chatMessage") {
        var chatBox = document.querySelector('.chat-messages');
        var newMessage = document.createElement('div');

        newMessage.innerHTML = `[<span class="text-purple-400">${item.id}</span>] <strong>${item.username}</strong>: ${item.message} <span class="text-xss text-gray-500 relative">${item.timestamp}</span>`;
        chatBox.appendChild(newMessage);

        // Scroll to the bottom of the chat box when a new message is added
        chatBox.scrollTop = chatBox.scrollHeight;
    }
});


document.getElementById('emoji-button').addEventListener('click', function() {
    var emojiPicker = document.getElementById('emoji-picker');
    emojiPicker.classList.toggle('hidden');
});


document.querySelectorAll('.emoji-btn').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission

        var emoji = this.textContent;
        var chatInput = document.getElementById('chat-input');
        chatInput.value += emoji; // Append emoji to input value

        chatInput.focus(); // Optionally, focus back to the input field
    });
});
</script>





        </div>
    </div>

</body>
</html>
