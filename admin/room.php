<?php
session_start();
include '../config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sunset Escape Villa - Admin</title>
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" xintegrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/room.css">
</head>

<body>
    <div class="addroomsection">
        <form action="" method="POST">
            <label for="troom">Type of Room :</label>
            <select name="troom" class="form-control">
                <option value selected></option>
                <option value="Superior Room">SUPERIOR ROOM</option>
                <option value="Deluxe Room">DELUXE ROOM</option>
                <option value="Guest House">GUEST HOUSE</option>
                <option value="Single Room">SINGLE ROOM</option>
            </select>

            <label for="bed">Type of Bed :</label>
            <select name="bed" class="form-control">
                <option value selected></option>
                <option value="Single">Single</option>
                <option value="Double">Double</option>
                <option value="Triple">Triple</option>
                <option value="Quad">Quad</option>
                <option value="Triple">None</option>
            </select>

            <button type="submit" class="btn btn-success" name="addroom">Add Room</button>
        </form>

        <?php
        if (isset($_POST['addroom'])) {
            $typeofroom = $_POST['troom'];
            $typeofbed = $_POST['bed']; // This variable is currently unused as 'bedding' column is removed from insertion

            // To add a new room, you need to provide room_number, type_id, status, and floor.
            // Assuming you want to add an available room with a default floor (e.g., 1) and a placeholder room_number.
            // You might want to generate a unique room_number or let the user input it.
            // For 'type_id', we fetch it from 'room_types' table based on 'type_name'.
            // Removed 'bedding' from the INSERT query as it's not in 'rooms' table.
            $sql = "INSERT INTO rooms (room_number, type_id, status, floor) VALUES (FLOOR(100 + RAND() * 899), (SELECT type_id FROM room_types WHERE type_name = '$typeofroom'), 'available', 1)";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                header("Location: room.php");
            } else {
                // You might want to add error handling here to see why the query failed
                echo "Error: " . mysqli_error($conn);
            }
        }
        ?>
    </div>

    <div class="room">
        <?php
        // Corrected SQL query to join 'rooms' with 'room_types' to get 'type_name'
        // and fetch 'room_number' and 'status'. Removed 'bedding' as it's not a column.
        $sql = "SELECT r.room_id as id, r.room_number, rt.type_name as type, r.status, r.floor FROM rooms r JOIN room_types rt ON r.type_id = rt.type_id";
        $re = mysqli_query($conn, $sql);
        ?>
        <?php
        while ($row = mysqli_fetch_array($re)) {
            $room_type = $row['type'];
            $room_number = $row['room_number'];
            $room_status = $row['status'];
            $room_floor = $row['floor'];

            // You can customize the display based on room type or status
            $room_box_class = 'roombox';
            if ($room_type == "Superior Room") {
                $room_box_class .= ' roomboxsuperior';
            } else if ($room_type == "Deluxe Room") {
                $room_box_class .= ' roomboxdelux';
            } else if ($room_type == "Guest House") {
                $room_box_class .= ' roomboguest';
            } else if ($room_type == "Single Room") {
                $room_box_class .= ' roomboxsingle';
            }

            echo "<div class='" . $room_box_class . "'>
                    <div class='text-center no-boder'>
                        <i class='fa-solid fa-bed fa-4x mb-2'></i>
                        <h3>" . $room_type . "</h3>
                        <div class='mb-1'>Room No: " . $room_number . "</div>
                        <div class='mb-1'>Status: " . $room_status . "</div>
                        <div class='mb-1'>Floor: " . $room_floor . "</div>
                        <a href='roomdelete.php?id=". $row['id'] ."'><button class='btn btn-danger'>Delete</button></a>
                    </div>
                </div>";
        }
        ?>
    </div>

</body>

</html>
