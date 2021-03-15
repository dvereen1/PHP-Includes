<?php

$projectModalArr = [
    "Common Knowledge" =>
    [
        "instructions" => "Follow the prompts and select the options to take your quiz.",
        "improvements" => "Because the UI of this application is updated dynamically via Javascript, meaning no page reloads, the browser's back button will redirect you to the porfolio section of the main page. Learning and implementing ways around this issue will improve useability. The current look and feel of the UI isn't my favorite, stylistic refreshes will be ongoing."
    ],
    "Ultimate Login" => 
    [
        "instructions" => "To test this application, create a fake account, with a fake name, email, etc. and then login. See what happens when you provide input that shouldn't belong or even try to bypass the login system.",
        "improvements" => "Beautify or perhaps add a feature to the profile page. For example, one that allows users to select a background image or color to make their profile unique. Continue to learn more about and implement better prevention of security threats such as cross-site scripting, cross-site request forgery and SQL injection as well as staying up to date on best practices regarding handling and storage of user data."
    ],
    "MemSafe" =>
    [
        "instructions" => "Follow the prompts to store a note with a unique secret, a secret which you'll use to retrieve the note later. Although each note you save is encrypted, useless gibberish to the naked eye, do not store any sensitive information as this project's code is available to anyone on GitHub.",
        "improvements" => "Upon a note upload, this application currently stores the server's date and time instead of the user's time. The time of upload between the user and the server may be inconsistent due to timezone differences. Continue to learn more about and implement better prevention of security threats such as cross-site scripting, cross-site request forgery and SQL injection as well as staying up to date on best practices regarding handling and storage of user data."
    ],
    "Brick Breaker" =>
    [ 
        "instructions" => "Mobile browser support coming soon. To move the paddle use the left and right arrow keys. To pause, press the escape key, ESC. Press spacebar to fire bullets and hit ball to create area damage. Break all the bricks to win.",
        "improvements" => "Add mobile device support. Create a custom spritesheet for the game. Identify memory leaks that cause the browser tab to become unresponsive if game is left idle for extended periods of time. While playing you may notice both the ball sometimes sticking to the paddle instead of immediately bouncing off after contact and odd behavior when the ball is destroyed by a bullet. Although the ball disappears from the screen after being hit by a bullet its state doesn't seem to change quickly enough in that, for perhaps several seconds after, other bullets can hit the, now invisible, ball or the position it was last in. This results in the ball being respawned at a much higher velocity since it has been 'destroyed' several times over. "
    ],
    "Space Invaders" =>
    [
        "instructions" => "Mobile browser support coming soon. Use the left and right arrow keys to dodge bullets from the aliens ( orange squares ). Press spacebar to fire bullets and destroy the enemies. Press the escape key, ESC, to pause.",
        "improvements" => "Add mobile device support. Create a custom spritesheet for the game.  Identify memory leaks that cause the browser tab to become unresponsive if game is left idle for extended periods of time. The aliens move side to side and when an alien is destroyed, its comrade should move to cover its path plus the path of the fallen comrade. The alien brigade should get closer to the player after each cycle of moving to the furthest left or right side of the screen."
    ],
   "Widget Space"=>
    [
        "instructions" => "As you make your way through the widgets, hover over or click the different items to test functionality.",
        "improvements" => "Create a custom carousel within which content can be scrolled or swiped through."
    ],
    /*"DJV Calculator" =>
    [
        "instructions" => "Perform some calculations; see if the results check out.  Implementing order of operations was trickier than I'd assumed and introduced several bugs in the process, some of which may still be lurking. What sequences break the calculator, if any at all?",
        "improvements" => "Add a visual that displays the history of the calculation. Identify the different calculation patterns that trigger unwanted results and work towards their prevention. Update the design."
    ]*/
    "Photo Gallery" =>
    [
        "instructions" => "As you make your way through the gallery, take note of what may not be quite inuitive or user-friendly.",
        "improvements" => "Once a photo is in the zoomed view, cycling through the remaining photos involves clicking the left or right arrow buttons. Many online photo viewers include similar buttons but also enable users to swipe or click and drag through pictures, something this gallery lacks. Comparing and brushing up on different JavaScript libraries that enable this functionality is necessary."
    ],
    "Cool Card Animation" => 
    [
        "instructions" => "Hover over the cards to learn more about the picture's photographer. How did the card hovering behave on your device? If you happen to be using a mobile device, are both cards easily accessible?",
        "improvements" => "Improve the user experience on mobile devices."
    ]

];

/**
 * Given the project name, creates project modal that holds instructions for a particular project.
 * 
 * @param {String} projectName - the name of the project launching the modal
 * @param {Array} projectModalArr - an array of arrays which holds specific titles and instructions used to construct the modal per project
 */

function createProjectModal($projectName, $projectModalArr){
    $projectTitle = $projectInstructions = $projectImprovements = null;

    if($projectName === "Common Knowledge"){
        $projectTitle = $projectName;
        $projectInstructions = $projectModalArr[$projectName]["instructions"];
        $projectImprovements = $projectModalArr[$projectName]["improvements"];
    }else if($projectName === "Ultimate Login"){
        $projectTitle = $projectName;
        $projectInstructions = $projectModalArr[$projectName]["instructions"];
        $projectImprovements = $projectModalArr[$projectName]["improvements"];
    }else if($projectName === "MemSafe"){
        $projectTitle = $projectName;
        $projectInstructions = $projectModalArr[$projectName]["instructions"];
        $projectImprovements = $projectModalArr[$projectName]["improvements"];
    }else if($projectName === "Brick Breaker"){
        $projectTitle = $projectName;
        $projectInstructions = $projectModalArr[$projectName]["instructions"];
        $projectImprovements = $projectModalArr[$projectName]["improvements"];
    }else if($projectName === "Space Invaders"){
        $projectTitle = $projectName;
        $projectInstructions = $projectModalArr[$projectName]["instructions"];
        $projectImprovements = $projectModalArr[$projectName]["improvements"];
    }else if($projectName === "Widget Space"){
        $projectTitle = $projectName;
        $projectInstructions = $projectModalArr[$projectName]["instructions"];
        $projectImprovements = $projectModalArr[$projectName]["improvements"];
    }else if($projectName === "Photo Gallery"){
        $projectTitle = $projectName;
        $projectInstructions = $projectModalArr[$projectName]["instructions"];
        $projectImprovements = $projectModalArr[$projectName]["improvements"];
     
    }else if($projectName === "Cool Card Animation"){
        $projectTitle = $projectName;
        $projectInstructions = $projectModalArr[$projectName]["instructions"];
        $projectImprovements = $projectModalArr[$projectName]["improvements"];
     
    }
    $modalHTML = "
        <section class ='project-modal'>
            <div class = 'project-modal-content'>
                <div class ='modal-title'>
                    <h1>A Word From The Developer</h1>
                </div>
                <div class ='modal-text'>
                    <h2>
                        Welcome to $projectTitle
                    </h2>
                    <div class ='modal-instructions'>
                        <p>
                            $projectInstructions
                        </p>
                    </div>
                    <div class ='modal-improvements'>
                        <div class = 'improve-title'>
                            <h3>Things To Improve</h3>
                            <button class = 'improve-btn'>
                                VIEW
                                <i class='fas fa-expand-arrows-alt'></i>
                            </button>
                        </div>
                        <div class = 'improve-text'>
                            <p>
                                $projectImprovements
                            </p>
                        </div>
                    </div>
                    <p class = 'contact'>
                        If you experienced any issues or have feedback email me at <b>contact@darianvereen.com</b>.
                    </p>
                    <button class = 'continue-btn'>
                        CONTINUE
                    </button>
                </div>
            </div>
        </section>
    ";

    echo $modalHTML;
}


