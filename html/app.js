window.addEventListener('load', function() {
  console.log('PauseMenu Started')
})

window.addEventListener('message', function(event) {
  var v = event.data

  switch(v.action) {

      case 'show':
			ShowSettings()
			$('#showupdates').hide();
			$('#showabout').hide();			
      break;

  }
})
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//  $$\   $$\ $$$$$$$$\  $$$$$$\  $$$$$$$\  $$$$$$$$\ $$$$$$$\                      $$\   $$\  $$$$$$\  $$\    $$\ $$$$$$\  $$$$$$\   $$$$$$\ $$$$$$$$\ $$$$$$\  $$$$$$\  $$\   $$\ 
//  $$ |  $$ |$$  _____|$$  __$$\ $$  __$$\ $$  _____|$$  __$$\                     $$$\  $$ |$$  __$$\ $$ |   $$ |\_$$  _|$$  __$$\ $$  __$$\\__$$  __|\_$$  _|$$  __$$\ $$$\  $$ |
//  $$ |  $$ |$$ |      $$ /  $$ |$$ |  $$ |$$ |      $$ |  $$ |                    $$$$\ $$ |$$ /  $$ |$$ |   $$ |  $$ |  $$ /  \__|$$ /  $$ |  $$ |     $$ |  $$ /  $$ |$$$$\ $$ |
//  $$$$$$$$ |$$$$$\    $$$$$$$$ |$$ |  $$ |$$$$$\    $$$$$$$  |      $$$$$$\       $$ $$\$$ |$$$$$$$$ |\$$\  $$  |  $$ |  $$ |$$$$\ $$$$$$$$ |  $$ |     $$ |  $$ |  $$ |$$ $$\$$ |
//  $$  __$$ |$$  __|   $$  __$$ |$$ |  $$ |$$  __|   $$  __$$<       \______|      $$ \$$$$ |$$  __$$ | \$$\$$  /   $$ |  $$ |\_$$ |$$  __$$ |  $$ |     $$ |  $$ |  $$ |$$ \$$$$ |
//  $$ |  $$ |$$ |      $$ |  $$ |$$ |  $$ |$$ |      $$ |  $$ |                    $$ |\$$$ |$$ |  $$ |  \$$$  /    $$ |  $$ |  $$ |$$ |  $$ |  $$ |     $$ |  $$ |  $$ |$$ |\$$$ |
//  $$ |  $$ |$$$$$$$$\ $$ |  $$ |$$$$$$$  |$$$$$$$$\ $$ |  $$ |                    $$ | \$$ |$$ |  $$ |   \$  /   $$$$$$\ \$$$$$$  |$$ |  $$ |  $$ |   $$$$$$\  $$$$$$  |$$ | \$$ |
//  \__|  \__|\________|\__|  \__|\_______/ \________|\__|  \__|                    \__|  \__|\__|  \__|    \_/    \______| \______/ \__|  \__|  \__|   \______| \______/ \__|  \__|

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ShowSettings() {

	$('.container').fadeIn()
  openUi = true
}

$(function(){
    $('#settings').click(function(){
      $.post('https://PauseMenu/SendAction', JSON.stringify({action: 'settings'}));
      CloseAll()
    })

    $('#map').click(function(){
      $.post('https://PauseMenu/SendAction', JSON.stringify({action: 'map'}));
      CloseAll()
    })

    $('#keyboard').click(function(){
      $.post('https://PauseMenu/SendAction', JSON.stringify({action: 'keyboard'}));
      CloseAll()
    })

    $('#resume').click(function(){
        CloseAll()
      })
	

    $('#exit').click(function(){
      $.post('https://PauseMenu/SendAction', JSON.stringify({action: 'exit'}));
        CloseAll()
    })

    $('#discordinv').click(function(){
        window.invokeNative('openUrl', 'https://discord.gg/infernorp')
    })

    $('#ig').click(function(){
      window.invokeNative('openUrl', 'https://www.instagram.com/inferno__roleplay/')
    })
})

function CloseAll(){
  $('.container').fadeOut()
  $.post('https://PauseMenu/exit', JSON.stringify({}));
  openUi = false
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//                                    $$$$$$\  $$$$$$$$\ $$$$$$$\  $$\    $$\ $$$$$$$$\ $$$$$$$\  $$$$$$$\   $$$$$$\  $$\   $$\ $$$$$$$$\ $$\       
//                                    $$  __$$\ $$  _____|$$  __$$\ $$ |   $$ |$$  _____|$$  __$$\ $$  __$$\ $$  __$$\ $$$\  $$ |$$  _____|$$ |      
//                                    $$ /  \__|$$ |      $$ |  $$ |$$ |   $$ |$$ |      $$ |  $$ |$$ |  $$ |$$ /  $$ |$$$$\ $$ |$$ |      $$ |      
//                                    \$$$$$$\  $$$$$\    $$$$$$$  |\$$\  $$  |$$$$$\    $$$$$$$  |$$$$$$$  |$$$$$$$$ |$$ $$\$$ |$$$$$\    $$ |      
//                                    \____$$\ $$  __|   $$  __$$<  \$$\$$  / $$  __|   $$  __$$< $$  ____/ $$  __$$ |$$ \$$$$ |$$  __|   $$ |      
//                                    $$\   $$ |$$ |      $$ |  $$ |  \$$$  /  $$ |      $$ |  $$ |$$ |      $$ |  $$ |$$ |\$$$ |$$ |      $$ |      
//                                    \$$$$$$  |$$$$$$$$\ $$ |  $$ |   \$  /   $$$$$$$$\ $$ |  $$ |$$ |      $$ |  $$ |$$ | \$$ |$$$$$$$$\ $$$$$$$$\ 
//                                    \______/ \________|\__|  \__|    \_/    \________|\__|  \__|\__|      \__|  \__|\__|  \__|\________|\________|                                                                                                              
              
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function updateServerStats() {
  $.post('https://PauseMenu/getServerData', {}, function(data) {
      if (data) {
          document.getElementById('userId').getElementsByClassName('stat-value')[0].textContent = `ID: ${data.userId}`;
          document.getElementById('playerCount').getElementsByClassName('stat-value')[0].textContent = `${data.playerCount}/${data.maxPlayers}`;
          document.getElementById('playerPing').getElementsByClassName('stat-value')[0].textContent = `${data.playerPing} ms`;
          document.getElementById('playerUsername').getElementsByClassName('stat-value')[0].textContent = `${data.playerName}`;
          document.getElementById('welcomeUsername').getElementsByClassName('stat-value')[0].textContent = `${data.playerWCName}`;
          document.getElementById('jobName').textContent = data.jobName;
      } else {
          // Handle error case
      }
  }).fail(function() {
      // Handle failure
  });
}

$(document).ready(function() {
  updateServerStats();
  setInterval(updateServerStats, 5000);
});



















function copyUserIdToClipboard() {
  var userIdElement = document.getElementById('userId').getElementsByClassName('stat-value')[0];
  var fullText = userIdElement.textContent;
  var actualId = fullText.replace('ID: ', '');

  if (!navigator.clipboard) {
      // Fallback method if Clipboard API fails
      manualCopyToClipboard(actualId);
      return;
  }

  navigator.clipboard.writeText(actualId).then(function() {
      console.log('User ID copied to clipboard:', actualId);
  }).catch(function(err) {
      console.error('Could not copy text:', err);
      // Fallback to manual copy
      manualCopyToClipboard(actualId);
  });
}

function manualCopyToClipboard(text) {
  var textArea = document.createElement("textarea");
  textArea.value = text;
  document.body.appendChild(textArea);
  textArea.focus();
  textArea.select();

  try {
      var successful = document.execCommand('copy');
      var msg = successful ? 'successful' : 'unsuccessful';
      console.log('Fallback: Copying text command was ' + msg);
  } catch (err) {
      console.error('Fallback: Oops, unable to copy', err);
  }

  document.body.removeChild(textArea);
}
