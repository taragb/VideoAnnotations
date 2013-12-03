<?php
<!DOCTYPE html>
<html>
<body>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<div style="float:left;width:700px">
    <h1>Video Annotations</h1>
  	Enter a Youtube Video ID (e.g. wC9E5zxFwxg): <input type="text" id="vidId"></input>
    <button id="play">Play</button> 
    <button id="pause">Annotate (Pause)</button>  
    <br /><br />
    <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
    <div id="player"></div>    
  </div>

  <div class="mailForm">
    <button id="sendMail">Email</button>
  </div>

  <div style="float:right;width:500px">
    <div class="annotationForm">
      <p>Enter your notes for this part of the video (<strong><span class="curTime"> seconds</span></strong>)</p>
      <input type="text" id="noteField"></input> <br />
      <button id="submitAnnotation">Submit</button>
    </div>
    <h2>My Annotations</h2>
    <table id="display_title">
      <tr>
        <th>Time</th>
        <th style="width:200px;">Note</th>
      </tr>
    </table>
    <table id="display">
      <tr>
        <th></th>
        <th style="width:200px;"></th>
      </tr>
    </table>
  </div>
	<script>
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');
      var inputOpened = false;
      // Annotation is a time stamp and a note
      var annotations = [];

      $('.annotationForm').hide();

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player; 
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '390',
          width: '640',
          videoId: 'gHGDN9-oFJE',
          events: {
            'onReady': onPlayerReady
          }
        });
      }
      $("#play").click(function() {
      	vid = $("#vidId").val();
      	console.log(vid);
      	player.loadVideoById(vid, 5, "large");
      });

      $("#submitAnnotation").click(function() {
      	console.log("cool");
        secondsElapsed = $('.curTime').text();
        noteWritten = $('#noteField').val();

        clearAnnotations();

        annotations.push({
          time: secondsElapsed,
          note: noteWritten
        });
        $('.annotationForm').hide();
        inputOpened = false;

        sortAnnotations(annotations);
        showAnnotations(annotations);

        player.playVideo();
      });

      function sortAnnotations(annotations) {
          annotations.sort(function(a,b){
            return a.time - b.time;
          });
      }

      function showAnnotations(annotations) {
        for (var i = 0; i < annotations.length; i++) {
          $('#display > tbody:last').append('<tr><td>' + annotations[i].time + '</td><td>' + annotations[i].note + '</td></tr>');
        }        
      }

      function clearAnnotations() {
        $('#display > tbody:last').empty();
      }

      $("#pause").click(function() {
      	if (inputOpened) { return; } 
	      $('.annotationForm').show();
	      var secondsElapsed = player.getCurrentTime();
	      $('.curTime').text(secondsElapsed);
	      console.log(secondsElapsed);
      	inputOpened = true;
      	player.pauseVideo();
      });

      $("#sendMail").click(function() {
        mail('taragb@gmail.com', 'Hi!', "What's been going on lately?");
        console.log("mail sent");
      });

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
      }
    </script>
</body>
</html>
?>