fx_version 'cerulean'

game 'gta5'
lua54 'yes'
version '1.0'
author 'push.42'

shared_script '@es_extended/imports.lua'

--Client Scripts-- 
client_scripts {
 'Client/**.lua',
 'config.lua',
 '@es_extended/locale.lua'
}

--Server Scripts-- 
server_scripts {
 'Server/**.lua',
 'config.lua',
 '@oxmysql/lib/MySQL.lua', -- oxmysql library
 '@es_extended/locale.lua',
 "@mysql-async/lib/MySQL.lua"
}


--UI Part-- 
ui_page {
 'html/index.html', 
}

--File Part-- 
files {
 'html/index.html',
 'html/app.js', 
 'html/style.css',
 'html/main.css',
 'html/assets/*.png',
 'html/assets/*.jpeg',
 'html/assets/*.webp',
 'html/assets/*.gif',
 'html/assets/*.jpg',
 'html/assets/*.wav',
 'html/assets/*.mp3',
 'html/assets/*.mp4'
} 

-- ESX Dependency
dependency 'es_extended' -- Make sure ESX is started before your script
dependency 'oxmysql' -- Add oxmysql as a dependency
dependency 'mysql-async'