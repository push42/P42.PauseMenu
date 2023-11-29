<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/9d1f4cdd15.js" crossorigin="anonymous"></script>
    <script src="app.js" defer></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>Pause-Menu by Push.42</title>
</head>


<div class="fixed left-12 top-4">
    <img id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" class="w-28 h-28 rounded-full cursor-pointer" src="./assets/pxrp.gif" alt="User dropdown">
    <div class="text-center text-sm font-sans font-bold text-purple-300 mt-1">EXAMPLEV</div>
    <div class="text-center text-sm font-sans text-purple-300 mt-20 mb-2">Usersettings</div>
    <button id="updateAvatar" class="clock-container absolute text-white text-xs p-0.5 rounded-lg font-medium ml-1">
        <i class="fa-regular fa-image text-purple-400 mr-2 text-xs"></i>Choose Avatar
    </button>
    <button id="reportPanel" class="clock-container absolute text-white text-xs p-0.5 rounded-lg font-medium ml-1 mt-8" onclick="openModal()">
        <i class="fa-solid fa-ban text-purple-400 mr-2 text-xs"></i>Report Panel
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
        <span class="stat-value text-sm ml-1"> No User found</span>
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
    <div class="fixed bottom-0 left-0 right-0 bg-zinc-900 bg-opacity-95 p-2 flex justify-around items-center shadow-lg z-40">
        <div id="resume" class="nav-item flex items-center space-x-2 cursor-pointer transition-transform transform hover:scale-105">
            <i class="fa-solid fa-play text-xl"></i>
            <span class="font-semibold">Resume</span>
        </div>
        <div id="settings" class="nav-item flex items-center space-x-2 cursor-pointer transition-transform transform hover:scale-105">
            <i class="fa-solid fa-gear text-xl"></i>
            <span class="font-semibold">Settings</span>
        </div>
        <div id="map" class="nav-item flex items-center space-x-2 cursor-pointer transition-transform transform hover:scale-105">
            <i class="fa-solid fa-map-location-dot text-xl"></i>
            <span class="font-semibold">Map</span>
        </div>
        <!-- <div id="info" class="nav-item">Info</div> -->
        <div id="keyboard" class="nav-item flex items-center space-x-2 cursor-pointer transition-transform transform hover:scale-105">
            <i class="fa-regular fa-keyboard text-xl"></i>
            <span class="font-semibold">Keyboard</span>
        </div>
        <div id="help" class="nav-item flex items-center space-x-2 cursor-pointer transition-transform transform hover:scale-105">
            <i class="fa-regular fa-circle-question text-xl"></i>
            <span class="font-semibold">Help</span>
        </div>
        <div id="exit" class="nav-item flex items-center space-x-2 cursor-pointer transition-transform transform hover:scale-105">
            <i class="fa-solid fa-door-open text-xl"></i>
            <span class="font-semibold">Exit</span>
        </div>
    </div>





    <style>
    /* Custom CSS for adjusting image background position */
    .newsImage1 {
        background-image: url('./assets/santeria2.png');
        background-size: cover;
        background-position: center; /* You can adjust this to change the visible part of the image */
        width: 100%;
        height: 200px; /* Keep the height fixed */
        background-position-y: 40%;
    }
</style>

<!-- Content Panels -->
<div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Main Panel -->
    <div class="md:col-span-2">
        <div class="panel bg-gradient-to-r from-zinc-950 to-zinc-900 bg-opacity-95 p-5 rounded-lg shadow-lg hover:scale-105">
            <h2 class="panel-heading uppercase font-black font-mono text-xl">
                <i class="fa-solid fa-thumbtack text-xs mr-2"></i>News / Announcements
            </h2>
            <div class="content">
                <!-- News Item -->
                <div class="news-item mb-4">
                    <div class="newsImage1 rounded-lg shadow-lg mb-2"></div>
                    <h3 class="text-lg text-white font-semibold mb-1 uppercase"><i class="fa-solid fa-thumbtack mr-2"></i>YOUR NEWS GO HERE</h3>
                    <p class="text-sm text-gray-300 mb-8 font-thin">Short description for news 1. Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus voluptatem odit vero dicta. Id voluptatem, aspernatur totam numquam voluptate fuga obcaecati. Sed ut perspiciatis minima. Amet quidem aut quis debitis.</p>
                    <div class="tags flex space-x-2">
                        <span class="tag text-xs bg-red-500 text-white rounded-full px-2 py-1 font-bold"><i class="fa-solid fa-bullhorn mr-1 text-xs"></i>Announcement</span>
                        <span class="tag text-xs bg-gray-800 text-white rounded-full px-2 py-1 font-bold"><i class="fa-solid fa-wrench mr-1 text-xs"></i>Update</span>
                        <span class="tag text-xs bg-purple-800 text-white rounded-full px-2 py-1 font-bold"><i class="fa-solid fa-calendar-check mr-1 text-xs"></i>Event</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


        
        

    <div class="panel bg-zinc-900 bg-opacity-95 p-5 rounded-lg shadow-lg hover:scale-105 transition-transform">
    <div>
        <h2 class="panel-heading uppercase font-black font-mono text-xl relative">
            <i class="fa-regular fa-circle text-xs mr-2"></i>Server Panel
            <span class="text-sm absolute right-14 top-2 text-gray-300">
                <i class="fa-brands fa-discord mr-2 mt-1"></i>DSC.GG/YOURSERVER
            </span>
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
            <div id="playerPing" class="player-stat badge" onclick="clickOnPing()">
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
    <div id="detailedUserInfo" class="absolute top-0 left-0 w-full h-full bg-zinc-900 text-white p-6 rounded-lg opacity-0 transition-opacity duration-500 z-10 hidden">
        <button id="closeUserInfo" class="absolute top-9 right-9 text-gray-300 hover:text-gray-100">
            <i class="fa fa-times text-2xl"></i>
        </button>

        <!-- Player Image -->
        <div class="flex items-center mb-6">
            <img id="up-avatar" src="player-avatar.jpg" alt="Player Image" class="w-20 h-20 rounded-full mr-4 shadow-lg"> <!-- Replace with actual image source -->
            <h2 id="playerName" class="text-2xl font-bold">John Doe</h2> <!-- Dynamic player name -->
        </div>

        <!-- Info Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm p-2">
            <!-- Job Info -->
            <div class="info-card flex items-center space-x-2 bg-blue-900 text-white rounded p-2">
                <i class="fa-solid fa-briefcase"></i> <!-- Job Icon -->
                <div class="info">
                    <p class="info-title font-semibold">Job:</p>
                    <p id="jobNameDetail" class="info-value">Not available</p>
                </div>
            </div>

            <!-- Rank Info -->
            <div class="info-card flex items-center space-x-2 bg-blue-900 text-white rounded p-2">
                <i class="fa-solid fa-briefcase"></i> <!-- Rank Icon -->
                <div class="info">
                    <p class="info-title font-semibold">Rank:</p>
                    <p id="groupDetail" class="info-value">Not available</p>
                </div>
            </div>

            <!-- Grade Info -->
            <div class="info-card flex items-center space-x-2 bg-green-900 text-white rounded p-2">
                <i class="fa-solid fa-medal"></i> <!-- Grade Icon -->
                <div class="info">
                    <p class="info-title font-semibold">Grade:</p>
                    <p id="jobGradeDetail" class="info-value">Not available</p>
                </div>
            </div>

            <!-- Height Info -->
            <div class="info-card flex items-center space-x-2 bg-purple-900 text-white rounded p-2">
                <i class="fa-solid fa-ruler-vertical"></i> <!-- Height Icon -->
                <div class="info">
                    <p class="info-title font-semibold">Height:</p>
                    <p id="heightDetail" class="info-value">Not available</p>
                </div>
            </div>

            <!-- Sex Info -->
            <div class="info-card flex items-center space-x-2 bg-red-900 text-white rounded p-2">
                <i class="fa-solid fa-venus-mars"></i> <!-- Sex Icon -->
                <div class="info">
                    <p class="info-title font-semibold">Sex:</p>
                    <p id="sexDetail" class="info-value">Not available</p>
                </div>
            </div>

            <!-- DOB Info -->
            <div class="info-card flex items-center space-x-2 bg-yellow-900 text-white rounded p-2">
                <i class="fa-solid fa-cake-candles"></i> <!-- DOB Icon -->
                <div class="info">
                    <p class="info-title font-semibold">DOB:</p>
                    <p id="dobDetail" class="info-value">Not available</p>
                </div>
            </div>
            <!-- Add more fields as needed -->

            <!-- Bank Info -->
            <div class="info-card flex items-center space-x-2 bg-indigo-900 text-white rounded p-2">
                <i class="fa-solid fa-wallet"></i> <!-- Bank Icon -->
                <div class="info">
                    <p class="info-title font-semibold">Bank:</p>
                    <p id="bankDetail" class="info-value">Not available</p>
                </div>
            </div>

            <!-- Money Info -->
            <div class="info-card flex items-center space-x-2 bg-green-900 text-white rounded p-2">
                <i class="fa-solid fa-money-bill"></i> <!-- Money Icon -->
                <div class="info">
                    <p class="info-title font-semibold">Money:</p>
                    <p id="moneyDetail" class="info-value">Not available</p>
                </div>
            </div>

            <!-- Black Money Info -->
            <div class="info-card flex items-center space-x-2 bg-red-900 text-white rounded p-2">
                <i class="fa-solid fa-money-bill"></i> <!-- Black Money Icon -->
                <div class="info">
                    <p class="info-title font-semibold">Black Money:</p>
                    <p id="blackMoneyDetail" class="info-value">Not available</p>
                </div>
            </div>

        </div>


            </div>


            <script>
                    // Assuming NUI is set up and this script can communicate with your FiveM resource's client script
                window.addEventListener('message', function(event) {
                    if (event.data.action === 'setPlayerInfo') {
                        var data = event.data.playerInfo;

                        // Update HTML elements with the player's data
                        document.getElementById('playerName').textContent = data.firstname + ' ' + data.lastname;
                        document.getElementById('jobNameDetail').textContent = data.job ? data.job : 'Not available';
                        document.getElementById('jobGradeDetail').textContent = data.grade ? data.grade : 'Not available';
                        document.getElementById('heightDetail').textContent = data.height ? data.height : 'Not available';
                        document.getElementById('groupDetail').textContent = data.group ? data.group : 'Not available';

                        // Convert 'm' or 'f' to 'Male' or 'Female'
                        var sexText = data.sex === 'm' ? 'Male' : (data.sex === 'f' ? 'Female' : 'Not available');
                        document.getElementById('sexDetail').textContent = sexText;

                        document.getElementById('dobDetail').textContent = data.dateofbirth ? data.dateofbirth : 'Not available';
                        document.getElementById('up-avatar').src = data.avatar;
                        document.getElementById('avatarButton').src = data.avatar;
                                // Parse the accounts data as JSON
                        var accountsData = JSON.parse(data.accounts);

                        // Update HTML elements with the player's data
                        document.getElementById('bankDetail').textContent = accountsData.bank ? '$' + accountsData.bank.toLocaleString() : 'Not available';
                        document.getElementById('moneyDetail').textContent = accountsData.money ? '$' + accountsData.money.toLocaleString() : 'Not available';
                        document.getElementById('blackMoneyDetail').textContent = accountsData.black_money ? '$' + accountsData.black_money.toLocaleString() : 'Not available';

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

                <!-- Improved User List Panel -->
                    <h3 class="text-md text-white font-semibold mb-2 relative overflow-hidden uppercase">
                        <i class="fa-solid fa-users mr-2 text-white text-sm"></i>Users <span class="text-purple-400">Online</span>
                        <!-- Animated Line -->
                        <span class="block h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 absolute bottom-0 left-0 right-0 animate-pulse"></span>
                    </h3>
                    <ul id="playerList" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- User Item -->
                        <li class="player-item inline-flex items-center rounded-md bg-zinc-900 px-2 py-1 text-xs font-medium text-purple-700 ring-2 ring-inset ring-gray-600/10 transform transition-transform hover:scale-105">
                            <div class="flex items-center justify-between mb-1">
                                <span class="flex items-center text-white">
                                    Username
                                </span>
                                <span class="text-xs font-mono ml-2 text-purple-400">1</span>
                            </div>
                            <div class="text-xss text-gray-400 text-center uppercase font-bold">
                                Police: <span class="relative font-medium text-purple-400">Officer</span>
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
                    <h2 class="font-semibold text-lg text-green-400 mt-4">
                        <i class="fa-solid fa-shopping-cart text-sm mr-2"></i>Visit <span class="text-green-400">our</span> Store.
                    </h2>
                    <h2>
                        <span class="donate-text font-sans font-medium">Looking for a way to support the Project?</span>
                    </h2>
                </div>
                <img src="./assets/tebex_shop.jpg" alt="Tebex Shop" class="rounded-full w-10 h-10">
            </div>            
            <p class="text-sm text-white mt-4">
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



<!-- Overlay for Live Support Panel -->
<div id="supportOverlay" class="support-overlay hidden fixed inset-0 bg-gray-900 bg-opacity-60 z-40"></div>

<!-- Live Support Modal Window -->
<div id="supportModal" class="support-modal hidden fixed inset-0 z-50 flex justify-center items-center p-4 bg-zinc-950 bg-opacity-90">
    <!-- Modal Content -->
    <div class="support-content bg-zinc-950 shadow-2xl rounded-lg overflow-hidden flex flex-col lg:flex-row border-2 border-zinc-700">
        <!-- Button to close the Support Panel -->
        <button id="closeSupportPanel" class="support-close-btn absolute top-4 right-4 text-gray-300 hover:text-white focus:outline-none">
            <i class="fas fa-times"></i>
        </button>
        <!-- Ticket Sidebar -->
        <aside class="support-sidebar bg-zinc-900 p-6 w-full lg:w-1/3">
            <h2 class="support-title text-3xl font-bold text-white mb-6"><i class="fa-solid fa-ticket text-purple-400 mr-4"></i>Ticket Panel</h2>
            <!-- Create a Ticket - button -->
            <button id="createTicketBtn" class="create-support-ticket mb-4 text-gray-300 hover:text-white focus:outline-none font-bold text-lm">
                <i class="fa-solid fa-plus text-purple-400 mr-2"></i>Create a Ticket
            </button>
            <ul class="support-ticket-list space-y-2">
                <li class="support-ticket text-gray-100 p-2 rounded-full font-semibold"><i class="fa-solid fa-bars mr-2"></i>Ticket 1 </li>
                <li class="support-ticket text-gray-100 p-2 rounded-full font-semibold"><i class="fa-solid fa-bars mr-2"></i>Ticket 2 </li>
                <!-- More tickets -->
            </ul>
        </aside>

        <!-- Chat Section -->
        <section class="support-chat flex-grow bg-zinc-850 p-6 w-full lg:w-2/3">
            <!-- Chat Area -->
            <div class="support-chat-area flex flex-col h-full">
                <!-- Chat Messages -->
                <div class="support-messages flex-grow overflow-y-auto mb-4">
                    <!-- Sample Messages -->
                    <div class="support-message mb-3">
                        <span class="message-author font-bold text-gray-200">User:</span>
                        <span class="message-text text-gray-300">Hi, I need help with an issue.</span>
                    </div>
                    <div class="support-message mb-3">
                        <span class="message-staff font-bold text-purple-500">Support:</span>
                        <span class="message-text text-gray-300">Sure, what can I assist you with?</span>
                    </div>
                    <!-- More messages -->
                </div>

                <!-- Chat Input -->
                <div class="support-input mt-4 flex">
                    <input type="text" class="support-input-field bg-zinc-900 text-white w-full p-3 rounded focus:outline-none" placeholder="Type your message...">
                    <button class="support-send-btn font-semibold bg-purple-600 text-white ml-3 px-4 py-2 rounded hover:bg-purple-700 transition-colors">Send</button>
                </div>
            </div>
        </section>
    </div>
</div>







        <div class="get-support-panel bg-zinc-900 bg-opacity-90 p-5 rounded-xl shadow-xl transform hover:scale-105 transition duration-300">
            <img src="./assets/get_support.png" alt="Tebex Shop Background" class="tebex-shop-bg">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-lg text-blue-400">
                    <i class="fa-solid fa-headset text-sm mr-2 text-white"></i>Need <span class="text-white">Assistance?</span>
                </h2>
                <img src="./assets/discord_logo.webp" alt="Discord Logo" class="rounded-full w-16 h-16">
            </div>
            <p class="text-sm text-white mt-4">
                Our dedicated support team is here to assist you. Feel free to reach out with any queries or concerns. Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate, sapiente.
            </p>
            <button type="button" id="openLiveSupport" class="inline-flex items-center px-3 py-1.5 text-sm font-bold text-center text-white bg-zinc-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-zinc-800 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-4">
                <i class="fa-solid fa-ticket mr-2 text-blue-400"></i>Live Support
            </button>    
            <button id="discord-btn" type="button" onclick="copyDiscordLink()" class="inline-flex items-center px-3 py-1.5 text-sm font-bold text-center text-white bg-zinc-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-zinc-800 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ml-2 mt-4">
                <i class="fa-brands fa-discord mr-2 text-blue-400"></i>Discord
            </button>
        </div>

        <!-- JavaScript Code -->
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

            function clickOnPing() {
                showSlideNotification("Experiencing Lags?  ", `Check out the performance Guides on our Discord Server!`, `DSC.GG/YOURSERVER`);
            }

            function obtainedDailyReward() {
                showSlideNotificationReward("Daily Reward", `You successfully received your daily reward!`, `REWARD OBTAINED`);
            }

            function lockedDailyReward() {
                showSlideNotificationRewardLocked("Daily Reward", `Sorry! You did not login at this day!`, `REWARD LOCKED`);
            }

            function unlockDailyReward() {
                showSlideNotificationRewardLocked("Daily Reward", `Reward not ready yet, come back tomorrow!`, `REWARD LOCKED`);
            }

            // Function to open the Live Support modal and hide the overlay
            function openLiveSupportModal() {
                document.getElementById('supportModal').classList.remove('hidden');
                document.getElementById('supportOverlay').classList.add('hidden');
            }

            document.querySelector('.support-send-btn').addEventListener('click', function() {
                var message = document.querySelector('.support-input-field').value;
                // Send this message to the server for the currently selected ticket
            });

            // Function to close the Live Support modal and show the overlay
            function closeLiveSupportModal() {
                document.getElementById('supportModal').classList.add('hidden');
                document.getElementById('supportOverlay').classList.add('hidden');
            }

            // Event listener for the "Live Support" button
            document.getElementById('openLiveSupport').addEventListener('click', openLiveSupportModal);
            document.getElementById('closeSupportPanel').addEventListener('click', closeLiveSupportModal);
        </script>


        <!-- Notify Modals -->
        <div id="notification-modal" class="hidden fixed inset-0 bg-zinc-900 bg-opacity-75 overflow-y-auto h-full w-full flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                    <h2 id="notification-title" class="text-xl font-semibold text-gray-800">Notification Title</h2>
                    <button onclick="closeNotificationModal()" class="text-gray-600 hover:text-gray-800 transition duration-150 ease-in-out">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p id="notification-message" class="text-gray-700 mb-6">Your notification message goes here.</p>
            </div>
        </div>


        <div id="slide-notification-reward-locked" class="hidden fixed top-1/4 right-0 transform translate-x-full transition duration-500 ease-in-out bg-gradient-to-r from-zinc-900 to-zinc-950 shadow-lg rounded-l-xl p-4 w-84">
            <audio class="hidden" id="notification-sound-reward-locked" src="./assets/error.wav" controls></audio>
            <div class="flex">
                <div class="mr-2">
                    <img src="./assets/a_lock.gif" alt="Image Alt Text" width="40" height="40">
                </div>
                <div>
                    <h2 id="slide-notification-title-reward-locked" class="text-lg font-bold text-gray-200 uppercase">Notification Title</h2>
                    <p id="slide-notification-message-reward-locked" class="text-gray-300 font-medium mt-2">Your notification message goes here.</p>
                    <p id="slide-notification-message-two-reward-locked" class="text-xs font-sans font-bold text-purple-300 absolute right-2 top-2">DSC.GG/YOURSERVER</p>
                </div>
            </div>
        </div>

        <div id="slide-notification-reward" class="hidden fixed top-1/4 right-0 transform translate-x-full transition duration-500 ease-in-out bg-gradient-to-r from-zinc-900 to-zinc-950 shadow-lg rounded-l-xl p-4 w-84">
            <audio class="hidden" id="notification-sound-reward" src="./assets/reward.mp3" controls></audio>
            <div class="flex">
                <div class="mr-2">
                    <img src="./assets/door_badge.webp" alt="Image Alt Text" width="40" height="40">
                </div>
                <div>
                    <h2 id="slide-notification-title-reward" class="text-lg font-bold text-gray-200 uppercase">Notification Title</h2>
                    <p id="slide-notification-message-reward" class="text-gray-300 font-medium mt-2">Your notification message goes here.</p>
                    <p id="slide-notification-message-two-reward" class="text-xs font-sans font-bold text-purple-300 absolute right-2 top-2">DSC.GG/YOURSERVER</p>
                </div>
            </div>
        </div>

        <div id="slide-notification" class="hidden fixed top-1/4 right-0 transform translate-x-full transition duration-500 ease-in-out bg-gradient-to-r from-zinc-900 to-zinc-950 shadow-lg rounded-l-xl p-4 w-84">
            <div class="flex">
                <div class="mr-2">
                    <img src="./assets/lag.gif" alt="Image Alt Text" width="40" height="40">
                </div>
                <div>
                    <h2 id="slide-notification-title" class="text-lg font-bold text-gray-200 uppercase">Notification Title</h2>
                    <p id="slide-notification-message" class="text-gray-300 font-medium mt-2">Your notification message goes here.</p>
                    <p id="slide-notification-message-two" class="text-xs font-sans font-bold text-purple-300 absolute right-2 top-2">DSC.GG/YOURSERVER</p>
                </div>
            </div>
        </div>
        <script>
        function showSlideNotification(title, message, messagetwo) {
            document.getElementById('slide-notification-title').innerText = title;
            document.getElementById('slide-notification-message').innerText = message;
            document.getElementById('slide-notification-message-two').innerText = messagetwo;

            var slideNotification = document.getElementById('slide-notification');
            slideNotification.classList.remove('hidden', 'hide');
            slideNotification.classList.add('show');

            setTimeout(() => {
                slideNotification.classList.remove('show');
                slideNotification.classList.add('hide');
            }, 5000); // Hide after 5 seconds
        }

        // Notify for Reward obtained
        function showSlideNotificationReward(title, message, messagetwo) {
            document.getElementById('slide-notification-title-reward').innerText = title;
            document.getElementById('slide-notification-message-reward').innerText = message;
            document.getElementById('slide-notification-message-two-reward').innerText = messagetwo;

            // Play the notification sound
            var audio = document.getElementById('notification-sound-reward');
            audio.play();

            var slideNotificationReward = document.getElementById('slide-notification-reward');
            slideNotificationReward.classList.remove('hidden', 'hide');
            slideNotificationReward.classList.add('show');

            setTimeout(() => {
                slideNotificationReward.classList.remove('show');
                slideNotificationReward.classList.add('hide');
            }, 5000); // Hide after 5 seconds
        }

        // Notify for Reward locked
        function showSlideNotificationRewardLocked(title, message, messagetwo) {
            document.getElementById('slide-notification-title-reward-locked').innerText = title;
            document.getElementById('slide-notification-message-reward-locked').innerText = message;
            document.getElementById('slide-notification-message-two-reward-locked').innerText = messagetwo;

            // Play the notification sound
            var audio = document.getElementById('notification-sound-reward-locked');
            audio.play();

            var slideNotificationRewardLocked = document.getElementById('slide-notification-reward-locked');
            slideNotificationRewardLocked.classList.remove('hidden', 'hide');
            slideNotificationRewardLocked.classList.add('show');

            setTimeout(() => {
                slideNotificationRewardLocked.classList.remove('show');
                slideNotificationRewardLocked.classList.add('hide');
            }, 5000); // Hide after 5 seconds
        }
        </script>




        <!-- Panel 3 - Global Leaderboard -->
        <div class="leaderboard-panel bg-zinc-900 bg-opacity-90 p-4 rounded-xl shadow-xl overflow-y-auto max-h-64">
            <h2 class="text-lg font-semibold text-white mb-4">
                <i class="fa-solid fa-trophy mr-2 text-yellow-400"></i>
                Leaderboard<span class="text-xs font-thin ml-4 text-gray-400">Top 10 players by playtime</span>
            </h2>
            <ul class="space-y-2">
                <!-- Leaderboard Item -->
                <!-- JavaScript will populate this list -->
            </ul>
        </div>
<script>
window.addEventListener('message', function (event) {
    var item = event.data;
    if (item.type === "updateLeaderboard") {
        var leaderboardList = document.querySelector('.leaderboard-panel ul');
        leaderboardList.innerHTML = ''; // Clear existing list
        item.players.slice(0, 10).forEach(function (player, index) {
            var playerElement = document.createElement('li');
            playerElement.className = 'flex items-center justify-between bg-zinc-900 bg-opacity-90 p-2 rounded-lg';

            var trophyIcon = '';
            if (index === 0) { // First place
                trophyIcon = '<i class="fa-solid fa-trophy text-gold ml-2"></i>';
            } else if (index === 1) { // Second place
                trophyIcon = '<i class="fa-solid fa-trophy text-silver ml-2"></i>';
            } else if (index === 2) { // Third place
                trophyIcon = '<i class="fa-solid fa-trophy text-bronze ml-2"></i>';
            }

            // Convert playtime from minutes to hours and minutes
            var totalMinutes = player.playtime;
            var hours = Math.floor(totalMinutes / 60);
            var minutes = totalMinutes % 60;

            playerElement.innerHTML = `
                <div class="flex items-center">
                    <img src="${player.avatar}" alt="${player.firstname}" class="w-8 h-8 rounded-full mr-2">
                    <span class="text-white text-sm">${player.firstname} ${player.lastname}</span>
                    ${trophyIcon}
                </div>
                <span class="text-gray-400 text-xs px-2 py-1 rounded-full font-semibold">Playtime: ${totalMinutes} min / ${hours} hrs</span>`;
            leaderboardList.appendChild(playerElement);
        });
    }
});
</script>


<!-- Modal Container for Player Reports (Hidden initially) -->
<div id="modal-container" class="hidden fixed inset-0 bg-zinc-950 bg-opacity-30 overflow-y-auto h-full w-full flex justify-center items-center backdrop-blur-sm " aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Modal Content -->
    <div class="relative top-0 mx-auto p-7 border-2 w-full md:w-1/2 lg:w-1/3 shadow-xl rounded-lg bg-zinc-900 space-y-4">
        <!-- Form Title -->
        <h2 class="text-2xl font-semibold text-white uppercase"><i class="fa-solid fa-user-large-slash text-purple-300 mr-2"></i>Send a Report</h2>

        <!-- Form Container -->
        <div class="form-container space-y-3">
            <!-- Form Fields -->
            <input type="text" id="fname" placeholder="First Name" class="w-full px-4 py-2 border rounded-md focus:border-purple-500 focus:outline-none bg-zinc-800 text-white">
            <input type="text" id="lname" placeholder="Last Name" class="w-full px-4 py-2 border rounded-md focus:border-purple-500 focus:outline-none bg-zinc-800 text-white">
            <select id="reporttype" class="text-gray-300 w-full px-4 py-2 border rounded-md focus:border-purple-500 focus:outline-none bg-zinc-800">
                <option value="">Choose a Report-Type</option>
                <option value="Player">Report Player</option>
                <option value="Bugs">Report Bugs & Glitches</option>
                <option value="Staff">Report Staff-Members</option>
                <option value="LostItems">Report Lost Items</option>
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












<!-- Panel 4 - Detailed Info Panel -->
<div class="panel bg-zinc-900 bg-opacity-90 p-2 rounded-lg shadow-lg col-span-2">
    <!-- Advent Calendar Panel -->
    <div class="advent-calendar-panel bg-zinc-900 bg-opacity-90 p-4 rounded-lg">
        <h2 class="font-semibold text-lg text-white mb-4 panel-heading"><i class="fa-solid fa-calendar-day mr-2 text-purple-400"></i>Daily<span class="text-purple-400"> Rewards</span><span class="text-xs font-medium ml-4 font-sans">This is a sample text and will soon be replaced.</span></h2>
        <div class="calendar-row flex overflow-x-auto pb-2" id="calendar-row">
            <!-- JavaScript will populate the calendar here -->
        </div>
    </div>
</div>

<script>
  // Get the current date
  const currentDate = new Date();
  const currentDay = currentDate.getDate(); // Get the day of the month (1-31)
  const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate(); // Get the total number of days in the current month

  // Create the calendar row
  const calendarRow = document.getElementById('calendar-row');
  for (let dayNumber = 1; dayNumber <= daysInMonth; dayNumber++) {
    const dayPanel = document.createElement('div');
    dayPanel.className = 'calender-door bg-gradient-to-r from-zinc-950 to-zinc-900 rounded-lg shadow-lg mr-4 ml-2 flex-none hover:scale-105';
    const dayHeader = document.createElement('div');
    dayHeader.className = 'day-header bg-zinc-950 text-white text-center py-1.5 rounded-t-lg font-bold text-xs';
    dayHeader.textContent = `DAY ${dayNumber}`;
    const dayContent = document.createElement('div');
    dayContent.className = 'day-content flex items-center justify-center p-4 h-14';
    const dayImage = document.createElement('img');
    dayImage.src = './assets/door_badge.webp';
    dayImage.alt = 'Player Report';
    
    // Add a click event to open the panel if it's obtainable
    if (dayNumber === currentDay) {
      dayPanel.classList.add('obtainable');
      dayPanel.addEventListener('click', () => {
        console.log('Clicked on the current day.'); // Add this line
        // Code to open the panel and give rewards
        obtainedDailyReward();
        dayPanel.classList.remove('obtainable');
        dayPanel.classList.add('opened');
      });
    } else if (dayNumber < currentDay) {
      dayPanel.classList.add('locked');
      dayPanel.addEventListener('click', () => {
        lockedDailyReward();
      });
    } else {
        dayPanel.classList.add('opened');
        dayPanel.addEventListener('click', () => {
            lockedDailyReward();
      });
    }
    
    dayContent.appendChild(dayImage);
    dayPanel.appendChild(dayHeader);
    dayPanel.appendChild(dayContent);
    calendarRow.appendChild(dayPanel);
  }
</script>







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

        newMessage.innerHTML = `[<span class="text-purple-400">${item.id}</span>] <strong>${item.username}</strong>: ${item.message} <span class="text-xss text-gray-500 relative">${item.timestamp}</span> <button class="report-btn text-red-500 text-xs" data-message-id="${item.id}"><i class="fa-solid fa-ban"></i></button>`;
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


// Event listener for report button
document.querySelector('.chat-messages').addEventListener('click', function(event) {
    if (event.target && event.target.matches('.report-btn')) {
        var messageId = event.target.getAttribute('data-message-id');
        // Trigger the report functionality here
        sendReportToServer(messageId);
    }
});

function sendReportToServer(messageId) {
    // Example: Sending a report to the server-side
    fetch(`https://${GetParentResourceName()}/reportMessage`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json; charset=UTF-8',
        },
        body: JSON.stringify({ messageId: messageId })
    });
}

</script>





        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/9d1f4cdd15.js" crossorigin="anonymous"></script>
    <script src="app.js" defer></script>
    <script src="main.js" defer></script>
</body>
</html>
