    <?php
    session_start();

    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        header("Location: login.php");
        exit;
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome to my Website - Portfolio</title>
        <link rel="stylesheet" href="css/index.css">

    </head>

    <body>

        <!-- Navigation bar -->
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="aboutme.html">About</a></li>
                <li><a href="resume.html">Resume</a></li>
                <li><a href="faq.html">FAQ</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="feedbacks.php">Feedbacks</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <section>

        <div class="transparent-box">
            <h2>Feedback Form</h2>
            <form action="process_feedback.php" method="post">
                <div class="form-group">
                    <label for="feedback">Feedback</label>
                    <textarea class="form-control" id="feedback" name="feedback" rows="3" placeholder="Enter Feedback" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Feedback</button>
            </form>
        </div>

        <div class="feedbacks-container">
            <div class="transparent-box ">
                <?php

                include "database.php";

                $stmt = $conn->prepare("SELECT feedbacks.feedback, feedbacks.created_at, tbl_users.first_name, tbl_users.last_name FROM feedbacks JOIN tbl_users ON feedbacks.user_id = tbl_users.id ORDER BY feedbacks.created_at DESC");
                $stmt->execute();
                $result = $stmt->get_result();

                $feedbacks = $result->fetch_all(MYSQLI_ASSOC);
                ?>

                <h2>Feedbacks</h2>
                <ul class="list-group">
                    <?php foreach ($feedbacks as $feedback): ?>
                        <li>
                            <p><strong><?php echo htmlspecialchars($feedback['first_name']) . ' ' . htmlspecialchars($feedback['last_name']); ?></strong></p>
                            <p><?php echo htmlspecialchars($feedback['feedback']); ?></p>
                            <small>Posted on <?php echo date('F j, Y, g:i a', strtotime($feedback['created_at'])); ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>

        </section>  

        

        <footer>
            <p>© 2024 Kozer. All rights reserved.</p>
        </footer>

    </body>

    </html>
