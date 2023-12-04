Config = {}


Config.TimerSettings = {

    PlayTime = {
        TimeToAddPoints = 60000, -- how often the player should get points added // in ms means == (60000 = 1 minute)
        AddPointsToScore = 1, -- how many points the player should get
        FetchLeaderboard = 60000, -- how often the Leaderboard should get refreshed // in ms means == (60000 = 1 minute)
        FetchOnlinePlayers = 60000
    }
    
}


-- Discord settings
Config.Discord = {
    -- Discord webhooks refer to; https://support.discord.com/hc/en-us/articles/228383668-Intro-to-Webhooks
    Webhook = 'https://discord.com/api/webhooks/1136788634520006686/tOvaDLuAHK0LGCOzQxYoD3AFrScrjTXTnhlrlZot0_hT4pS8bAAsWu4j8-yO4-cuJqcD',
    -- Webhook colour can find more here; -- https://www.spycolor.com/
    Colour = 10309819, -- purple
    
    
    -- Discord bot username;
    BotData = {
        Name = 'Server Bot2',
        Logo = 'https://i.ibb.co/2F11vDn/push422.png', -- Avatar of Bot
        Footer = {
            Text = 'Your Server Name',
            Icon = 'https://i.ibb.co/sRRJ882/ezgif-com-video-to-apng-1.png' -- bottom left / footer
        },
    },

    -- Customizable Embed Data
    EmbedData = {
        TitlePrefix = '🔔 New Report - ',
        ThumbnailURL = 'https://i.ibb.co/yXrtCWf/neues-1.webp', -- top right
        Author = {
            Name = 'Report System',
            IconURL = 'https://i.ibb.co/3YjBHp7/drug-meth.png' -- top left
        },
        Translation = {
            ReportContent = '📄 Report Content',
            Subject = '**Subject:**',
            Description = '\n**Description:**',
            ReporterDetails = '👤 Reporter Details',
            FirstName = '**First Name:**',
            LastName = '\n**Last Name:**',
            DiscordADD = '\n**Discord:**',
            AdditionalInformation = '🔍 Additional Information',
            IngameID = '**ID:**',
            FiveMLicense = '\n**License:** ||'
        }
    }
}


-- Checks if player received reward / not and day changed to update its data.
-- Default is every 10 minutes.
Config.ThreadRepeat = 10

-- If Config.MythicNotifyMessage is set to false, ESX Messages will be sent than mythic_notify.
Config.MythicNotifyMessage = false

Config.RewardPacks    = {
    ['clips'] = {
        rewards = {
            ['1'] = {name = "disc_ammo_pistol",  type = "item", amount = 5},
            ['2'] = {name = "disc_ammo_rifle",   type = "item", amount = 5},
            ['3'] = {name = "disc_ammo_smg",     type = "item", amount = 5},
        },
    },
    ['moneyrewards'] = {
        rewards = {
            ['1'] = {name = "",  type = "money", amount = 50},
            ['2'] = {name = "",  type = "black_money", amount = 500},
            ['3'] = {name = "",  type = "bank", amount = 5000},
        },
    },

    ['weaponpack'] = {
        rewards = {
            ['1'] = {name = "WEAPON_PISTOL",  type = "weapon", amount = 0},
            ['2'] = {name = "WEAPON_APPISTOL",  type = "weapon", amount = 0},
        },
    },
}

Config.DailyRewards = {
    ['WEEK_1'] = {
        {
            day = 1,
            dayReward = {
                type = 'moneyrewards',
                reward = 'CASH',
                amount = 1,
                title = 'MONEY REWARDS',
                description = '- $50 CASH, $500 BLACK MONEY & $5000 BANK ACCOUNT',
                image = 'img/items/coins_rewardbox.png'
            },
        },
        {
            day = 2,
            dayReward = {
                type = 'clips',
                reward = 'clips',
                amount = 1,
                title = 'CLIPS',
                description = '- 5x PISTOL, AR & SMG CLIPS',
                image = 'img/items/vests_and_ammo_rewardbox.png'
            },
        },
    
        {
            day = 3,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_COMBATPDW',
                amount = 1,
                title = 'UMP-45',
                description = '',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    
    
        {
            day = 4,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_MICROSMG',
                amount = 1,
                title = 'UZI',
                description = '',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    
        {
            day = 5,
            dayReward = {
                type = 'item',
                reward = 'medikit',
                amount = 5,
                title = 'MEDICAL',
                description = '- 5x MEDICAL SUPPLEMENTS',
                image = 'img/items/items_rewardbox.png'
            },
        },
    
        {
            day = 6,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_PUMPSHOTGUN',
                amount = 1,
                title = 'PUMP SHOTGUN',
                description = '',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    
        {
            day = 7,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_COMPACTRIFLE',
                amount = 50,
                title = 'COMPACT RIFLE',
                description = '',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    },

    ['WEEK_2'] = {
        {
            day = 8,
            dayReward = {
                type = 'money',
                reward = 'CASH',
                amount = 50,
                title = 'CASH',
                description = '- $50 CASH',
                image = 'img/items/coins_rewardbox.png'
            },
        },
        {
            day = 9,
            dayReward = {
                type = 'clips',
                reward = 'clips',
                amount = 1,
                title = 'CLIPS',
                description = '- 5x PISTOL, AR & SMG CLIPS',
                image = 'img/items/vests_and_ammo_rewardbox.png'
            },
        },
    
        {
            day = 10,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_COMBATPDW',
                amount = 1,
                title = 'UMP-45',
                description = '- “Who said personal weaponry couldnt be worthy of military personnel? Thanks to our lobbyists, not Congress. Integral suppressor.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    
    
        {
            day = 11,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_MICROSMG',
                amount = 1,
                title = 'UZI',
                description = '- “Combines compact design with a high rate of fire at approximately 700-900 rounds per minute.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    
        {
            day = 12,
            dayReward = {
                type = 'item',
                reward = 'medikit',
                amount = 5,
                title = 'MEDICAL',
                description = '- 5x MEDICAL SUPPLEMENTS',
                image = 'img/items/items_rewardbox.png'
            },
        },
    
        {
            day = 13,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_PUMPSHOTGUN',
                amount = 1,
                title = 'PUMP SHOTGUN',
                description = '- “Standard shotgun ideal for short-range combat. A high-projectile spread makes up for its lower accuracy at long range.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    
        {
            day = 14,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_COMPACTRIFLE',
                amount = 50,
                title = 'COMPACT RIFLE',
                description = '- “Half the size, all the power, double the recoil: theres no riskier way to say Im compensating for something.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    },

    ['WEEK_3'] = {
        {
            day = 15,
            dayReward = {
                type = 'money',
                reward = 'CASH',
                amount = 50,
                title = 'CASH',
                description = '- $50 CASH',
                image = 'img/items/coins_rewardbox.png'
            },
        },
        {
            day = 16,
            dayReward = {
                type = 'clips',
                reward = 'clips',
                amount = 1,
                title = 'CLIPS',
                description = '- 5x PISTOL, AR & SMG CLIPS',
                image = 'img/items/box.png'
            },
        },
    
        {
            day = 17,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_COMBATPDW',
                amount = 1,
                title = 'UMP-45',
                description = '- “Who said personal weaponry couldnt be worthy of military personnel? Thanks to our lobbyists, not Congress. Integral suppressor.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    
    
        {
            day = 18,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_MICROSMG',
                amount = 1,
                title = 'UZI',
                description = '- “Combines compact design with a high rate of fire at approximately 700-900 rounds per minute.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    
        {
            day = 19,
            dayReward = {
                type = 'item',
                reward = 'medikit',
                amount = 5,
                title = 'MEDICAL',
                description = '- 5x MEDICAL SUPPLEMENTS',
                image = 'img/items/items_rewardbox.png'
            },
        },
    
        {
            day = 20,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_PUMPSHOTGUN',
                amount = 1,
                title = 'PUMP SHOTGUN',
                description = '- “Standard shotgun ideal for short-range combat. A high-projectile spread makes up for its lower accuracy at long range.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    
        {
            day = 21,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_COMPACTRIFLE',
                amount = 50,
                title = 'COMPACT RIFLE',
                description = '- “Half the size, all the power, double the recoil: theres no riskier way to say Im compensating for something.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    },

    ['WEEK_4'] = {
        {
            day = 22,
            dayReward = {
                type = 'money',
                reward = 'CASH',
                amount = 50,
                title = 'CASH',
                description = '- $50 CASH',
                image = 'img/items/coins_rewardbox.png'
            },
        },
        {
            day = 23,
            dayReward = {
                type = 'clips',
                reward = 'clips',
                amount = 1,
                title = 'CLIPS',
                description = '- 5x PISTOL, AR & SMG CLIPS',
                image = 'img/items/vests_and_ammo_rewardbox.png'
            },
        },
    
        {
            day = 24,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_COMBATPDW',
                amount = 1,
                title = 'UMP-45',
                description = '- “Who said personal weaponry couldnt be worthy of military personnel? Thanks to our lobbyists, not Congress. Integral suppressor.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    
    
        {
            day = 25,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_MICROSMG',
                amount = 1,
                title = 'UZI',
                description = '- “Combines compact design with a high rate of fire at approximately 700-900 rounds per minute.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    
        {
            day = 26,
            dayReward = {
                type = 'item',
                reward = 'medikit',
                amount = 5,
                title = 'MEDICAL',
                description = '- 5x MEDICAL SUPPLEMENTS',
                image = 'img/items/items_rewardbox.png'
            },
        },
    
        {
            day = 27,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_PUMPSHOTGUN',
                amount = 1,
                title = 'PUMP SHOTGUN',
                description = '- “Standard shotgun ideal for short-range combat. A high-projectile spread makes up for its lower accuracy at long range.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    
        {
            day = 28,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_COMPACTRIFLE',
                amount = 50,
                title = 'COMPACT RIFLE',
                description = '- “Half the size, all the power, double the recoil: theres no riskier way to say Im compensating for something.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },

        {
            day = 29,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_COMPACTRIFLE',
                amount = 50,
                title = 'COMPACT RIFLE',
                description = '- “Half the size, all the power, double the recoil: theres no riskier way to say Im compensating for something.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },

        {
            day = 30,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_COMPACTRIFLE',
                amount = 50,
                title = 'COMPACT RIFLE',
                description = '- “Half the size, all the power, double the recoil: theres no riskier way to say Im compensating for something.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },

        {
            day = 31,
            dayReward = {
                type = 'weapon',
                reward = 'WEAPON_COMPACTRIFLE',
                amount = 50,
                title = 'COMPACT RIFLE',
                description = '- “Half the size, all the power, double the recoil: theres no riskier way to say Im compensating for something.”',
                image = 'img/items/weapons_rewardbox.png'
            },
        },
    },
}





return Config