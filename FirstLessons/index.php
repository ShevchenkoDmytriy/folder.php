<?php
// Function to display directory contents
function displayDirectory($dir)
{
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo $file . '<br>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }

        .action-buttons {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>File Management System</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Folder/File Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="type">Type:</label>
            <select id="type" name="type">
                <option value="folder">Folder</option>
                <option value="file">File</option>
            </select>

            <button type="submit" name="create">Create</button>
        </form>

        <?php
        $baseDir = getcwd(); // Get the current working directory

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
            $name = $_POST["name"];
            $type = $_POST["type"];

            $path = $baseDir . '/' . $name;

            if ($type === "folder" && !file_exists($path) && mkdir($path)) {
                echo "<p>Folder '$name' created successfully.</p>";
            } elseif ($type === "file" && !file_exists($path) && touch($path)) {
                echo "<p>File '$name' created successfully.</p>";
            } else {
                echo "<p>Error creating $type '$name'. Check if it already exists.</p>";
            }
        }

        echo "<h3>Contents of directory:</h3>";
        displayDirectory($baseDir);
        ?>
    </div>
</body>

</html>
