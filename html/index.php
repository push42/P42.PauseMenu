<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/9d1f4cdd15.js" crossorigin="anonymous"></script>
    <script src="app.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Pause-Menu by Push.42</title>
</head>


<body class="container mx-auto bg-zinc-950 bg-opacity-95 text-gray-200 font-sans m-0 relative">
    <!-- Avatar Update Panel -->
    <div id="avatarUpdatePanel" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex justify-center items-center z-50">
        <div class="bg-white p-4 rounded-lg shadow-lg w-1/3">
            <h3 class="text-lg font-semibold mb-3">Update Avatar</h3>
            <input type="text" id="avatarUrlInput" class="border border-gray-300 p-2 w-full rounded-md" placeholder="Enter new avatar URL">
            <div class="flex justify-end space-x-2 mt-4">
                <button id="cancelAvatarUpdate" class="bg-red-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button id="confirmAvatarUpdate" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
            </div>
        </div>
    </div>
    <!-- Player Username -->
    <div id="welcomeUsername" class="player-stat badge ml-10 mt-6 mb-6 text-sm">
        <i class="fa-solid fa-minus mr-2 text-sm"></i>Welcome back, 
        <span class="stat-value text-sm ml-1"> No User found</span>.
    </div>
    <!-- Clock Container -->
    <div class="clock-container absolute top-0 right-6 flex items-center mb-2">
        <i class="fa-solid fa-clock mr-2 text-lg"></i>
        <span id="current-time" class="text-sm font-semibold"></span>
    </div>
        <button id="updateAvatar" class="clock-container absolute text-white text-sm p-1.5 rounded-lg right-40 top-1 font-medium"><i class="fa-regular fa-image text-purple-400 mr-2"></i>Change Avatar</button>
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
                    <!-- News Item 1 -->
                    <div class="news-item mb-4">
                        <img src="https://i.ibb.co/yXrtCWf/neues-1.webp" alt="News 1" id="newsImage1" class="newsImage1 rounded-lg shadow-lg h-40 object-cover mb-2">
                        <h3 class="text-lg text-white font-semibold mb-1 uppercase"><i class="fa-solid fa-thumbtack mr-2"></i>YOUR NEWS GO HERE</h3>
                        <p class="text-xs text-gray-300 mb-8 font-thin">Short description for news 1. Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus voluptatem odit vero dicta. Id voluptatem, aspernatur totam numquam voluptate fuga obcaecati. Sed ut perspiciatis minima. Amet quidem aut quis debitis.</p>
                        <div class="tags">
                            <span class="tag text-xs bg-red-500 text-white rounded-full px-2 py-1 mr-1 font-bold"><i class="fa-solid fa-bullhorn mr-2"></i>Announcement</span>
                            <span class="tag text-xs bg-gray-800 text-white rounded-full px-2 py-1 mr-1 font-bold"><i class="fa-solid fa-wrench mr-2"></i>Update</span>
                            <span class="tag text-xs bg-purple-800 text-white rounded-full px-2 py-1 mr-1 font-bold"><i class="fa-solid fa-calendar-check mr-2"></i>Event</span>
                        </div>
                        <a href="#" class="read-more absolute bottom-4 right-2 text-xs bg-zinc-800 text-white rounded-full px-2 py-1"><i class="fa-solid fa-arrow-up-right-from-square mr-2 text-xs"></i>Read more..</a>
                    </div>
                    <!-- Repeat for other news items -->
                </div>
            </div>
        </div>
        
        

        <div class="panel bg-zinc-900 bg-opacity-95 p-5 rounded-lg shadow-lg drop-shadow-lg">
        <div>
            <h2 class="panel-heading uppercase font-black font-mono">
                <i class="fa-regular fa-circle text-xs mr-2"></i>Server Panel<span class="text-sm absolute right-14 text-gray-300"><i class="fa-brands fa-discord mr-2 mt-1"></i>DSC.GG/SERVER</span>
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

                <!-- <div id="jobName" class="player-stat badge text-xs">
                    <i class="fa-solid fa-building text-purple-400"></i>
                    <span class="stat-value text-xs">--/--</span>
                </div> -->
            </div>



        <!-- Online Players List -->
        <div class="online-players mt-4 bg-zinc-900 bg-opacity-90 p-5 rounded-lg shadow-inner max-h-60 overflow-y-auto">
            <!-- Detailed User Info Container -->
            <div id="detailedUserInfo" class="absolute top-0 left-0 w-full h-full bg-zinc-900 text-white p-4 rounded-lg shadow-xl opacity-0 transition-opacity duration-500 z-10 hidden">
                <button id="closeUserInfo" class="absolute top-1 right-1 text-white">
                    <i class="fa fa-times"></i>
                </button>

                <!-- Player Image -->
                <div class="flex items-center mb-4">
                    <img src="player-avatar.jpg" alt="Player Image" class="w-16 h-16 rounded-full mr-4"> <!-- Replace with actual image source -->
                    <h2 id="playerName" class="text-xl font-semibold">John Doe</h2> <!-- Dynamic player name -->
                </div>

                <!-- Info Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <p id="jobNameDetail" class="info-item">Job: <span class="text-blue-400">Not available</span></p>
                    <p id="jobGradeDetail" class="info-item">Grade: <span class="text-blue-400">Not available</span></p>
                    <p id="heightDetail" class="info-item">Height: <span class="text-blue-400">Not available</span></p>
                    <p id="sexDetail" class="info-item">Sex: <span class="text-blue-400">Not available</span></p>
                    <p id="dobDetail" class="info-item">DOB: <span class="text-blue-400">Not available</span></p>
                    <!-- Add more fields as needed -->
                </div>
            </div>

            <script>
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

                <h3 class="text-md text-white font-semibold mb-2 relative overflow-hidden text-white uppercase"><i class="fa-solid fa-users mr-2 text-white text-sm"></i>Users <span class="text-purple-400">Online</span>
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
                        <!-- Filler Players -->
                        <li class="player-item inline-flex items-center rounded-md bg-zinc-900 px-2 py-1 text-xs font-medium text-purple-700 ring-2 ring-inset ring-gray-600/10">
                            <div class="flex items-center justify-between mb-1">
                                <span class="flex items-center text-white">
                                    Username
                                </span>
                                <span class="text-xs font-mono ml-2 text-purple-400">2</span>
                            </div>
                            <div class="text-xss text-gray-400 text-center uppercase font-bold">
                                Police: <span class="relative font-medium">Commander</span>
                            </div>
                        </li>
                        <!-- Filler Players -->
                        <li class="player-item inline-flex items-center rounded-md bg-zinc-900 px-2 py-1 text-xs font-medium text-purple-700 ring-2 ring-inset ring-gray-600/10">
                            <div class="flex items-center justify-between mb-1">
                                <span class="flex items-center text-white">
                                    Username
                                </span>
                                <span class="text-xs font-mono ml-2 text-purple-400">3</span>
                            </div>
                            <div class="text-xss text-gray-400 text-center uppercase font-bold">
                                Police: <span class="relative font-medium">Recruit</span>
                            </div>
                        </li>
                        <!-- Filler Players -->
                        <li class="player-item inline-flex items-center rounded-md bg-zinc-900 px-2 py-1 text-xs font-medium text-purple-700 ring-2 ring-inset ring-gray-600/10">
                            <div class="flex items-center justify-between mb-1">
                                <span class="flex items-center text-white">
                                    Username
                                </span>
                                <span class="text-xs font-mono ml-2 text-purple-400">4</span>
                            </div>
                            <div class="text-xss text-gray-400 text-center uppercase font-bold">
                                EMS: <span class="relative font-medium">Medic</span>
                            </div>
                        </li>
                        <!-- Filler Players -->
                        <li class="player-item inline-flex items-center rounded-md bg-zinc-900 px-2 py-1 text-xs font-medium text-purple-700 ring-2 ring-inset ring-gray-600/10">
                            <div class="flex items-center justify-between mb-1">
                                <span class="flex items-center text-white">
                                    Username
                                </span>
                                <span class="text-xs font-mono ml-2 text-purple-400">5</span>
                            </div>
                            <div class="text-xss text-gray-400 text-center uppercase font-bold">
                                UBER: <span class="relative font-medium">Driver</span>
                            </div>
                        </li>
                        <!-- Filler Players -->
                        <li class="player-item inline-flex items-center rounded-md bg-zinc-900 px-2 py-1 text-xs font-medium text-purple-700 ring-2 ring-inset ring-gray-600/10">
                            <div class="flex items-center justify-between mb-1">
                                <span class="flex items-center text-white">
                                    Username
                                </span>
                                <span class="text-xs font-mono ml-2 text-purple-400">6</span>
                            </div>
                            <div class="text-xss text-gray-400 text-center uppercase font-bold">
                                FBI: <span class="relative font-medium">Officer</span>
                            </div>
                        </li>
                        <!-- Filler Players -->
                        <li class="player-item inline-flex items-center rounded-md bg-zinc-900 px-2 py-1 text-xs font-medium text-purple-700 ring-2 ring-inset ring-gray-600/10">
                            <div class="flex items-center justify-between mb-1">
                                <span class="flex items-center text-white">
                                    Username
                                </span>
                                <span class="text-xs font-mono ml-2 text-purple-400">7</span>
                            </div>
                            <div class="text-xss text-gray-400 text-center uppercase font-bold">
                                LS Motors: <span class="relative font-medium">Mechanic</span>
                            </div>
                        </li>
                        <!-- Filler Players -->
                        <li class="player-item inline-flex items-center rounded-md bg-zinc-900 px-2 py-1 text-xs font-medium text-purple-700 ring-2 ring-inset ring-gray-600/10">
                            <div class="flex items-center justify-between mb-1">
                                <span class="flex items-center text-white">
                                    Username
                                </span>
                                <span class="text-xs font-mono ml-2 text-purple-400">8</span>
                            </div>
                            <div class="text-xss text-gray-400 text-center uppercase font-bold">
                                East Customs: <span class="relative font-medium">Owner</span>
                            </div>
                        </li>
                        <!-- Filler Players -->
                        <li class="player-item inline-flex items-center rounded-md bg-zinc-900 px-2 py-1 text-xs font-medium text-purple-700 ring-2 ring-inset ring-gray-600/10">
                            <div class="flex items-center justify-between mb-1">
                                <span class="flex items-center text-white">
                                    Username
                                </span>
                                <span class="text-xs font-mono ml-2 text-purple-400">9</span>
                            </div>
                            <div class="text-xss text-gray-400 text-center uppercase font-bold">
                                DoJ: <span class="relative font-medium">Judge</span>
                            </div>
                        </li>
                        <!-- Filler Players -->
                        <li class="player-item inline-flex items-center rounded-md bg-zinc-900 px-2 py-1 text-xs font-medium text-purple-700 ring-2 ring-inset ring-gray-600/10">
                            <div class="flex items-center justify-between mb-1">
                                <span class="flex items-center text-white">
                                    Username
                                </span>
                                <span class="text-xs font-mono ml-2 text-purple-400">9</span>
                            </div>
                            <div class="text-xss text-gray-400 text-center uppercase font-bold">
                                Police: <span class="relative font-medium">Officer</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <!-- Panel 1 - Tebex Shop Section -->
        <div class="tebex-shop-panel bg-zinc-900 bg-opacity-90 p-5 rounded-xl shadow-xl transform hover:scale-105 transition duration-300">
            <img src="https://i.ibb.co/Jq1Jyv9/tebex-bg.png" alt="Tebex Shop Background" class="tebex-shop-bg">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-lg text-green-400">
                        <i class="fa-solid fa-shopping-cart text-sm mr-2"></i>Visit <span class="text-green-400">our</span> Store.
                    </h2>
                    <h2>
                        <span class="donate-text font-sans font-medium">Looking for a way to support the Project?</span>
                    </h2>
                </div>
                <img src="https://pbs.twimg.com/profile_images/1687115424750817280/cqI9n9ih_400x400.jpg" alt="Tebex Shop" class="rounded-full w-16 h-16">
            </div>            
            <p class="text-sm text-gray-300 mt-4">
                Check out exclusive items and special offers available in our Tebex Shop. Lorem ipsum dolor sit amet consectetur adipisicing elit.
            </p>
            <ul class="grid w-full gap-2 md:grid-cols-1 absolute bottom-0 right-0">
                <li>
                    <input type="radio" id="hosting-small" name="hosting" value="hosting-small" class="hidden peer" required="">
                    <label for="hosting-small" class="scur inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white rounded-lg cursor-pointer dark:hover:text-gray-300 dark:peer-checked:text-green-400 peer-checked:text-green-400 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-zinc-900 dark:hover:bg-gray-700">                           
                        <div class="block">
                            <img class="w-10 h-10 rounded-full mx-auto absolute" src="https://i.ibb.co/r4KmhTG/animated-lp.webp">
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
            <img src="https://i.ibb.co/7R3bQ57/support.png" alt="Tebex Shop Background" class="tebex-shop-bg">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-lg text-blue-400">
                    <i class="fa-solid fa-headset text-xs mr-2"></i>Need <span class="text-white">Assistance?</span>
                </h2>
                <img src="https://static.vecteezy.com/system/resources/previews/018/930/718/original/discord-logo-discord-icon-transparent-free-png.png" alt="Tebex Store" class="rounded-full w-16 h-16">
            </div>
            <p class="text-sm text-gray-100 mt-4">
                Our dedicated support team is here to assist you. Feel free to reach out with any queries or concerns. Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate, sapiente.
            </p>
            <!-- <button class="support-button mt-4 px-4 py-2 rounded-md bg-blue-500 text-white font-semibold hover:bg-blue-600 transition duration-200">
                Contact Support
            </button> -->
            <button type="button" class="inline-flex items-center px-3 py-1.5 text-sm font-bold text-center text-white bg-zinc-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-zinc-800 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <i class="fa-solid fa-ticket mr-2 text-blue-400"></i>Live Support
                <!-- <span class="inline-flex items-center justify-center w-4 h-4 ms-2 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
                2
                </span> -->
            </button>    
            <button type="button" class="inline-flex items-center px-3 py-1.5 text-sm font-bold text-center text-white bg-zinc-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-zinc-800 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ml-2 mt-7">
                <i class="fa-brands fa-discord mr-2 text-blue-400"></i>Discord
            </button>   
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
                        <img src="https://i.ibb.co/BKSN4Lv/pxrp-less-then-10mb-1.gif" alt="Player 1" class="w-8 h-8 rounded-full mr-2">
                        <span class="text-white text-sm">Player 1</span><i class="fa-solid fa-trophy fa-beat fa-xs ml-4" style="color: #ffff80;"></i>
                    </div>
                    <span class="badge bg-gray-800 text-white text-xs px-2 py-1 rounded-full font-bold shadow-lg">Score: 1500</span>
                </li>
                <!-- Repeat for other players -->
                <!-- ... -->
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





        <!-- Panel 3 - Detailed Info Panel -->
        <div class="panel bg-zinc-900 bg-opacity-90 p-5 rounded-lg shadow-lg col-span-2">
            <h2 class="panel-heading font-semibold text-lg"><i class="fa-regular fa-circle text-xs mr-2"></i>Ignore this part, still in work</h2>
            <div class="grid grid-cols-2 gap-2 mt-2">
                <div class="text-sm">Ignore this part, still in work</div>
                <div class="text-sm">Ignore this part, still in work</div>
                <!-- Add more details as needed -->
            </div>
        </div>




<!-- Chatbox Panel -->
<div class="chatbox-panel bg-zinc-900 bg-opacity-90 p-4 rounded-xl shadow-xl">
    <h2 class="text-lg font-semibold text-white mb-4"><i class="fa-regular fa-comments mr-2"></i>Community Chat</h2>
    <div class="chat-messages overflow-y-auto max-h-150 pt-10 pb-5">
        <!-- Chat messages will be dynamically inserted here -->
    </div>
    <form id="chat-form" class="flex items-center">
        <button type="button" id="emoji-button" class="emoji-btn">😀</button>
        <input type="text" id="chat-input" class="bg-zinc-800 text-white p-1.5 rounded-lg w-full" placeholder="Type a message...">
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg">Send</button>

        <div id="emoji-picker" class="emoji-picker hidden absolute bg-gray-300 p-2 border border-gray-300 rounded-lg">
            <!-- Emojis -->
            <button class="emoji-btn">😂</button>
            <button class="emoji-btn">😁</button>
            <button class="emoji-btn">😊</button>
            <button class="emoji-btn">😉</button>
            <button class="emoji-btn">😘</button>
            <button class="emoji-btn">🤮</button>
            <button class="emoji-btn">🤐</button>
            <button class="emoji-btn">🫤</button>
            <button class="emoji-btn">😴</button>
            <button class="emoji-btn">🫡</button>
            <button class="emoji-btn">🤡</button>
            <button class="emoji-btn">💀</button>
            <button class="emoji-btn">❤️</button>
            <!-- Add more emojis as needed -->
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

        newMessage.innerHTML = `[<span class="text-purple-400">${item.id}</span>] <strong>${item.username} </strong> <span class="text-xs text-gray-600">${item.timestamp}</span>: ${item.message}`;
        chatBox.appendChild(newMessage);

        // Scroll to the bottom of the chat box when a new message is added
        chatBox.scrollTop = chatBox.scrollHeight;
    }
});


// Handle emoji button clicks
document.getElementById('emoji-button').addEventListener('click', function() {
    var emojiPicker = document.getElementById('emoji-picker');
    emojiPicker.classList.toggle('active'); // Toggle visibility of emoji picker
});

document.querySelectorAll('.emoji-picker .emoji-btn').forEach(button => {
    button.addEventListener('click', function() {
        const chatInput = document.getElementById('chat-input');
        chatInput.value += this.textContent; // Append emoji to chat input
        chatInput.focus(); // Refocus on the input field
        document.getElementById('emoji-picker').classList.remove('active'); // Close the picker
    });
});
</script>





        </div>
    </div>

</body>
</html>
