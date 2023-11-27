Config = {}


Config.TimerSettings = {

    PlayTime = {
        TimeToAddPoints = 6000, -- how often the player should get points added // in ms means == (60000 = 1 minute)
        AddPointsToScore = 1, -- how many points the player should get
        FetchLeaderboard = 6000, -- how often the Leaderboard should get refreshed // in ms means == (60000 = 1 minute)
        FetchOnlinePlayers = 6000
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

