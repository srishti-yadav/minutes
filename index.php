<html>

<head>
    
    <style>
        .area{
background: rgb(100,100,140);
            height: 500px;
            width: 600px;
            border-radius:0px 100px 0px 100px ;
        }
        #final_span{
            padding: 50px 20px;
            height: 460px;
            width: 560px;
            background: transparent;
            padding: 10px;
            outline: none;
            color: white;
            padding: 20px;
        }
        
        #start_button {
            text-decoration: none;
            color: rgb(100,100,200);
            
        }
        textarea{
            resize: none;
            border-radius: 0px 100px;
        }
        
        input{
            padding: 2px;
            border-radius: 4px;
        }
        button{
            border-radius: 4px;
            padding: 3px;
        }
    
    </style>
    
    </head>

    <body>
    <center>
<div>
    <a href="#" id="start_button" onclick="startDictation(event)"><h2> <i>Start Dictation </i></h2> </a>
</div>
    
               <form method="post">

    <div class="area">
 '<div id="results" >
           <!--  <span id="interim_span" class="interim"> </span> -->
            <textarea id="final_span" class="final" name="final_text"></textarea> 
         
        </div>
        </div>
                    <button name="subb">submitt</button>
        </form>
        
        
        <br>
        Filename to Save As: 
        <input id="inputFileNameToSaveAs">  
        <button onclick="saveTextAsFile()">Save Text to File</button> <br>
        <br>
        Select a File to Load:
          <input type="file" id="fileToLoad">
          <button onclick="loadFileAsText()">Load Selected File</button>
        <br>
                   
       
<?php 
               {     $MyText ='';   

       if(isset($_POST['subb']))
           $MyText= $_POST['final_text'];
            $webService = 'https://resoomer.pro/summarizer/';
$datasPost = 'API_KEY=CF2B178A234D828A59BEA309F68BDF7C&text='.$MyText;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $webService);
curl_setopt($ch,CURLOPT_POST, 2);
curl_setopt($ch,CURLOPT_POSTFIELDS, $datasPost);
$result = curl_exec($ch);
curl_close($ch);
echo $result;
       }
        ?> 
  <!--   
 < ?php
       
       if(isset($_POST['submit'])){
           echo "hellllllllllllllllllllllloooooooooooooo";
$MyText = 'Automatic summarization is the process of shortening a text document with software, in order to create a summary with the major points of the original document. Technologies that can make a coherent summary take into account variables such as length, writing style and syntax.

Automatic data summarization is part of machine learning and data mining. The main idea of summarization is to find a subset of data which contains the "information" of the entire set. Such techniques are widely used in industry today. Search engines are an example; others include summarization of documents, image collections and videos. Document summarization tries to create a representative summary or abstract of the entire document, by finding the most informative sentences, while in image summarization the system finds the most representative and important (i.e. salient) images. For surveillance videos, one might want to extract the important events from the uneventful context.

There are two general approaches to automatic summarization: extraction and abstraction. Extractive methods work by selecting a subset of existing words, phrases, or sentences in the original text to form the summary. In contrast, abstractive methods build an internal semantic representation and then use natural language generation techniques to create a summary that is closer to what a human might express. Such a summary might include verbal innovations. Research to date';
        
        $webService = 'https://resoomer.pro/summarizer/';
$datasPost = 'API_KEY=CF2B178A234D828A59BEA309F68BDF7C&text='.$MyText;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $webService);
curl_setopt($ch,CURLOPT_POST, 2);
curl_setopt($ch,CURLOPT_POSTFIELDS, $datasPost);
$result = curl_exec($ch);
curl_close($ch);
echo $result;

    }
?>
-->
        </center>
        
        
<script type="text/javascript">
    
    function saveTextAsFile()
{
    var textToSave = document.getElementById("final_span").value;
    var textToSaveAsBlob = new Blob([textToSave], {type:"text/plain"});
    var textToSaveAsURL = window.URL.createObjectURL(textToSaveAsBlob);
    var fileNameToSaveAs = document.getElementById("inputFileNameToSaveAs").value;
 
    var downloadLink = document.createElement("a");
    downloadLink.download = fileNameToSaveAs;
    downloadLink.innerHTML = "Download File";
    downloadLink.href = textToSaveAsURL;
    downloadLink.onclick = destroyClickedElement;
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
 
    downloadLink.click();
}
    
function destroyClickedElement(event)
{
    document.body.removeChild(event.target);
}
 
function loadFileAsText()
{
    var fileToLoad = document.getElementById("fileToLoad").files[0];
 
    var fileReader = new FileReader();
    fileReader.onload = function(fileLoadedEvent) 
    {
        var textFromFileLoaded = fileLoadedEvent.target.result;
        document.getElementById("final_span").value = textFromFileLoaded;
    };
    fileReader.readAsText(fileToLoad, "UTF-8");
}    
        
var final_transcript = '';
var recognizing = false;

if ('webkitSpeechRecognition' in window) {

  var recognition = new webkitSpeechRecognition();

  recognition.continuous = true;
  recognition.interimResults = true;

  recognition.onstart = function() {
    recognizing = true;
  };

  recognition.onerror = function(event) {
    console.log(event.error);
  };

  recognition.onend = function() {
    recognizing = false;
  };

  recognition.onresult = function(event) {
    var interim_transcript = '';
    for (var i = event.resultIndex; i < event.results.length; ++i) {
      if (event.results[i].isFinal) {
        final_transcript += event.results[i][0].transcript;
      } else {
        interim_transcript += event.results[i][0].transcript;
      }
    }
    final_transcript = capitalize(final_transcript);
    final_span.innerHTML = linebreak(final_transcript);
    interim_span.innerHTML = linebreak(interim_transcript);
    
  };
}

var two_line = /\n\n/g;
var one_line = /\n/g;
function linebreak(s) {
  return s.replace(two_line, '<p></p>').replace(one_line, '<br>');
}

function capitalize(s) {
  return s.replace(s.substr(0,1), function(m) { return m.toUpperCase(); });
}

function startDictation(event) {
  if (recognizing) {
    recognition.stop();
    return;
  }
  final_transcript = '';
  recognition.lang = 'en-IN';
  recognition.start();
  final_span.innerHTML = '';
  interim_span.innerHTML = '';
}
</script>
    
    </body>
</html>