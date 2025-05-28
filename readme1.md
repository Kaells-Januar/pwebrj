 <?php

    if (isset($_POST['username'])) {

        $username = $_POST['username'];
        $password = md5 ($_POST['password']);

        $query = mysqli_query($koneksi, "SELECT*FROM user WHERE username='$username' and password='$password'");
    
        if(mysqli_num_rows($query) > 0){
            $data = mysqli_fetch_array($query);
            $_SESSION['user'] = $data;
            echo '<script>alert("selamat datang, '.$data['nama']. '");
            location.href="index.php"; </script>';

        }else{

            echo '<script>alert("Username atau Password salah");</script>';

        }


        }
        
    
    

    ?>