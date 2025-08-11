<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>🎧 What's Playing? | VibeBox</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background: #000;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      text-align: center;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      margin: 0;
      padding: 0 20px;
    }

    h2 {
      margin-top: 60px;
      margin-bottom: 60px;
      font-size: 1.8rem;
    }

    #micButton {
      background: #00f0ff;
      border: none;
      border-radius: 50%;
      padding: 40px;
      font-size: 60px;
      color: #000;
      cursor: pointer;
      box-shadow: 0 0 30px #00f0ff;
      transition: 0.3s ease;
    }

    #micButton.listening {
      animation: pulse 1.2s infinite;
    }

    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 #ff408166; }
      70% { box-shadow: 0 0 0 30px transparent; }
      100% { box-shadow: 0 0 0 0 transparent; }
    }

    .lyrics, .result {
      margin-top: 30px;
      background: rgba(255,255,255,0.1);
      padding: 20px;
      border-radius: 10px;
      display: none;
      width: 90%;
      max-width: 600px;
    }

    iframe {
      margin-top: 20px;
    }

    .back-link {
      margin-top: 40px;
    }

    .back-link a {
      color: #00f0ff;
      text-decoration: none;
      font-weight: bold;
      font-size: 1rem;
      background: #111;
      padding: 10px 20px;
      border-radius: 8px;
      border: 1px solid #00f0ff;
      transition: 0.3s ease;
    }

    .back-link a:hover {
      background: #00f0ff;
      color: #000;
    }

    footer {
      margin-top: auto;
      padding: 15px 0;
      color: #00f0ff;
      font-size: 0.85rem;
    }
  </style>
</head>
<body>

<h2>🎶WHAT SONG IS THE DJ CURRENTLY PLAYING ?🎵<br> Press the icon below to find out👇</h2><br><br>
  <button id="micButton" onclick="startRecording()">🎙️</button>

  <div class="result" id="songResult">
    <h2 id="songTitle">🎵</h2>
    <p id="songArtist">👤</p>
    <div id="lyrics" class="lyrics"></div>
    <div id="video"></div>
  </div>

  <div class="back-link">
    <a href="index.php">⬅️ Back to Home</a>
  </div>

  <footer>
    Developed by Dev.Brian Musila @github |built by a dj for a dj| VibeBox 2025 
  </footer>

  <script>
    function startRecording() {
      const micBtn = document.getElementById('micButton');
      micBtn.classList.add('listening');
      micBtn.disabled = true;

      navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
        const mediaRecorder = new MediaRecorder(stream);
        let chunks = [];

        mediaRecorder.ondataavailable = e => chunks.push(e.data);
        mediaRecorder.onstop = () => {
          const audioBlob = new Blob(chunks, { type: 'audio/webm' });
          const formData = new FormData();
          formData.append('audio', audioBlob, 'recording.webm');

          fetch('whatsplaying-handler.php', {
            method: 'POST',
            body: formData
          })
          .then(res => res.json())
          .then(data => {
            micBtn.classList.remove('listening');
            micBtn.disabled = false;

            if (data.success) {
              document.getElementById('songResult').style.display = 'block';
              document.getElementById('songTitle').innerText = '🎵 ' + data.title;
              document.getElementById('songArtist').innerText = '👤 ' + data.artist;
              document.getElementById('lyrics').innerText = data.lyrics;

              if (data.youtube_id) {
                document.getElementById('video').innerHTML = `
                  <iframe width="300" height="170" 
                    src="https://www.youtube.com/embed/${data.youtube_id}" 
                    frameborder="0" allowfullscreen></iframe>`;
              }
            } else {
              alert('❌ Error: ' + data.error);
            }
          });
        };

        mediaRecorder.start();
        setTimeout(() => mediaRecorder.stop(), 10000); // 10 seconds max
      }).catch(err => {
        micBtn.classList.remove('listening');
        micBtn.disabled = false;
        alert('🎙️ Microphone access denied or unavailable.');
      });
    }
  </script>
</body>
</html>
