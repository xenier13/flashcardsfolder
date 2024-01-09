<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Norwegian Flashcards</title>
    <style>
        html {
            overflow-y: scroll;
        }

        body {
            overflow-y: scroll;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        /* The alert message box */
         .alert {
              padding: 20px;
              background-color: #f44336; /* Red */
              color: white;
              margin-bottom: 15px;
        }

        /* The close button */
        .closebtn {
              margin-left: 15px;
              color: white;
              font-weight: bold;
              float: right;
              font-size: 22px;
              line-height: 20px;   
             cursor: pointer;
              transition: 0.3s;
        }

        /* When moving the mouse over the close button */
        .closebtn:hover {
          color: black;
        } 

        #flashcard-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        #flashcard {
            width: 90%;
            min-width: 200px;
            max-width: 400px;
            height: 200px;
            background-color: #fff;
            border: 2px solid #000;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 20px;
        }

        #buttons {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            padding: 10px;
        }

        #remainingCards {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        .button {
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #555;
        }

        .button:active {
            transform: translateY(3px);
        }

        #flipButton, #rightButton, #wrongButton {
            background-color: #4CAF50;
            color: white;
        }

        #reviewButton {
            background-color: #FF0000;
            color: white;
        }

        .tableButton {
            background-color: blue;
            color: white;
        }

        .disabled {
            opacity: 0.3;
            cursor: not-allowed;
            pointer-events: none;
        }

        #additionalFields {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        #numberInput, #textInput {
            padding: 10px;
            font-size: 16px;
            border: 2px solid #000;
            border-radius: 5px;
        }

        #dropdownMenu {
            padding: 10px;
            font-size: 16px;
            border: 2px solid #000;
            border-radius: 5px;
        }

        #flashcard-container {
            text-align: center;
            margin-bottom: 20px;
            animation: spinAnimation 0.5s;
        }

        /* Adjustments for smaller screens */
        @media screen and (max-width: 600px) {
            #flashcard {
                width: 80%;
                min-width: 300px; /* Adjusted width for smaller screens */
                max-width: none; /* Remove max-width for smaller screens */
                height: 150px; /* Adjusted height for smaller screens */
                font-size: 16px; /* Adjusted font size for smaller screens */
            }

            #flashcard-container {
                margin-bottom: 10px; /* Adjusted margin for smaller screens */
            }

            #buttons {
                flex-direction: column;
                align-items: stretch;
            }

            .button {
                width: 100%;
                margin-bottom: 10px;
            }

            #additionalFields {
                flex-direction: column;
                align-items: stretch;
            }

            #numberInput,
            #textInput,
            #dropdownMenu {
                width: 100%;
                margin-bottom: 10px;
            }
        }
        @keyframes spinAnimation {
            0% {
                transform: rotateY(0deg);
            }
            100% {
                transform: rotateY(180deg);
            }
        }
    </style>
</head>
<body>

<div id="alert-box" class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    <div id="alert"></div>
</div> 

<div id="flashcard-title">Flashcards</div>
<div id="flashcard-container">
    <div id="flashcard">Loading...</div>
</div>

<div id="remainingCards">
    <span id="deckLength"></span>
</div>

<div id="buttons">
    <button class="button" id="flipButton" onclick="animateButton(this)">Flip</button>
    <button class="button" id="rightButton" onclick="animateButton(this)">Right</button>
    <button class="button" id="wrongButton" onclick="animateButton(this)">Wrong</button>
    <button class="button" id="reviewButton" onclick="animateButton(this)">Review</button>
    <span id="mistakesLength"></span>
</div>
<div id="buttons">
    <button class="button tableButton" id="A1 Vocab" onclick="animateButton(this)">A1 Vocab</button>
    <button class="button tableButton" id="Simple Verbs" onclick="animateButton(this)">Simple Verbs</button>
    <button class="button tableButton" id="Substantivfraser" onclick="animateButton(this)">Substantivfraser</button>
    <button class="button tableButton" id="B2Exam Vocab" onclick="animateButton(this)">B2Exam Vocab</button>
    <button class="button tableButton" id="Basic Verbs" onclick="animateButton(this)">Basic Verbs</button>
    <button class="button tableButton" id="Extra Verbs" onclick="animateButton(this)">Extra Verbs</button>
    <button class="button tableButton" id="Irregular Nouns" onclick="animateButton(this)">Irregular Nouns</button>
    <button class="button tableButton" id="Irregular Verbs" onclick="animateButton(this)">Irregular Verbs</button>
    <button class="button tableButton" id="Learning Verbs" onclick="animateButton(this)">Learning Verbs</button>
    <button class="button tableButton" id="Prepositions" onclick="animateButton(this)">Prepositions</button>
</div>

<div id="additionalFields">
    <input type="number" id="numberInput" placeholder="How many words?">
    <input type="text" id="textInput" placeholder="Contains?">
    <select id="dropdownMenu">
        <option value="randomized">Randomized</option>
        <option value="ordered">Ordered</option>
    </select>
</div>

<div id="buttons">
    <button class="button" id="animationToggle" onclick="toggleAnimation()">Toggle Animation</button>
</div>

<script defer>
    let isFlipped = false;
    let deck = [];
    let mistakes = [];
    let currentTable = "simple_verbs";
    let isAnimationEnabled = true;

    document.getElementById("flipButton").addEventListener("click", function () {
        isFlipped = true;
        updateFlashcard();
    });

    document.getElementById("rightButton").addEventListener("click", function () {
        isFlipped = false;
        loadNextFlashcard(false);
    });

    document.getElementById("wrongButton").addEventListener("click", function () {
        isFlipped = false;
        loadNextFlashcard(true);
    });

    document.getElementById("reviewButton").addEventListener("click", function () {
        isFlipped = false;
        loadMistakes();
    });

    // Create table buttons dynamically
    const tableButtons = document.querySelectorAll('.tableButton');

    tableButtons.forEach(button => {
        button.addEventListener("click", function () {
            currentTable = convertSpacesToUnderscores(button.id);
            document.getElementById("flashcard-title").innerText = button.id;
            loadDeck(currentTable);
        });
    });

    async function loadDeck(tableName) {
        try {
            var url = `getDeck.php?table=${tableName}`;
            const numOfWords = document.getElementById('numberInput').value;
            if (numOfWords !== "" && numOfWords !== null) {
                url += `&numberOfWords=${numOfWords}`;
            }
            
            const contains = document.getElementById('textInput').value;
            if (contains !== "" && contains !== null) {
                url += `&contains=${contains}`;
            }
            
            const order = document.getElementById("dropdownMenu").value;
            if (order !== "" && order !== null) {
                url += (`&order=${order}`);
            }

            //console.log(url);
            const response = await fetch(url);

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
                console.log(`HTTP error! Status: ${response.status}`);
            }

            const result = await response.json();
            deck = result;
            if (isFlipped) isFlipped = !isFlipped;
            updateTotals();
            updateFlashcard();
        } catch (error) {
            displayErrorMessage('Error:', error);
            console.log('Error: ', error);
        }
    }

    function loadMistakes() {
        deck = mistakes;
        mistakes = [];
        updateTotals();
        enableFlipButton();
        disableReviewButton();
        updateFlashcard();
    }

    function loadNextFlashcard(hasMistake) {
        if (hasMistake) {
            if (mistakes.length === 0) { enableReviewButton();}
                mistakes.push(deck.shift());
            } else { deck.shift(); }
        if (deck.length > 0) {
            updateFlashcard();
        } else {
            disableFlipButton();
            disableRightButton();
            disableWrongButton();
            document.getElementById("flashcard").innerText = "No more cards...";
        }
        updateTotals();
    }

    function updateFlashcard() {
        const flashcard = document.getElementById("flashcard");
        flashcard.innerText = "";

        if(isAnimationEnabled) {
            const flashcardContainer = document.getElementById("flashcard-container");
            flashcardContainer.style.animation = "none"; // Reset animation
            flashcardContainer.offsetHeight; /* Trigger reflow */
            flashcardContainer.style.animation = null; // Reapply animation

            setTimeout(function() {
                if (isFlipped) {
                    flashcard.innerText = deck[0].answer;
                    disableFlipButton();
                    enableRightButton();
                    enableWrongButton();
                } else {
                flashcard.innerText = deck[0].question;
                    enableFlipButton();
                    disableRightButton();
                    disableWrongButton();
                }
            }, 500); // milliseconds
        } else {
            if (isFlipped) {
                flashcard.innerText = deck[0].answer;
                disableFlipButton();
                enableRightButton();
                enableWrongButton();
            } else {
            flashcard.innerText = deck[0].question;
                enableFlipButton();
                disableRightButton();
                disableWrongButton();
            } 
        }


    }

    function toggleAnimation() {
        isAnimationEnabled = !isAnimationEnabled;
        const toggleButton = document.getElementById("animationToggle");

        if (isAnimationEnabled) {
            toggleButton.innerText = "Disable Animation";
        } else {
            toggleButton.innerText = "Enable Animation";
        }
    }

    function enableFlipButton() {
        document.getElementById("flipButton").classList.remove("disabled");
    }

    function disableFlipButton() {
        document.getElementById("flipButton").classList.add("disabled");
    }

    function enableRightButton() {
        document.getElementById("rightButton").classList.remove("disabled");
    }

    function disableRightButton() {
        document.getElementById("rightButton").classList.add("disabled");
    }

    function enableWrongButton() {
        document.getElementById("wrongButton").classList.remove("disabled");
    }

    function disableWrongButton() {
        document.getElementById("wrongButton").classList.add("disabled");
    }

    function enableReviewButton() {
        document.getElementById("reviewButton").classList.remove("disabled");
    }

    function disableReviewButton() {
        document.getElementById("reviewButton").classList.add("disabled");
    }

    function displayErrorMessage(errorText) {
        document.getElementById("alert-box").style.display = 'inline';
        document.getElementById("alert").innerText = errorText;
    }

    function updateTotals(){
        const totalDeck = "Remaining cards: "+deck.length;
        const totalMistakes = mistakes.length;
        document.getElementById("deckLength").innerHTML = totalDeck;
        document.getElementById("mistakesLength").innerHTML = totalMistakes;
    }

    function hideErrorMessage() {
        document.getElementById("alert-box").style.display = 'none';
    }

    function convertSpacesToUnderscores(str) {
        return str.replace(/\s+/g, '_').toLowerCase();
    }

    function animateButton(button) {
        button.style.animation = "buttonClick 0.3s ease";
        setTimeout(() => {
            button.style.animation = "";
        }, 300);
    }

    document.getElementById("flashcard-title").innerText = "Simple Verbs";
    loadDeck("a1_vocab");
    disableReviewButton();
    hideErrorMessage();
</script>
</body>
</html>