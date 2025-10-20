<html>
<head>
    <title>Contoh Form dengan POST</title>
</head>
<body>
    <h1>Buku Tamu</h1>
    Komentar dan saran sangat kami butuhkan untuk meningkatkan kualitas situs kami.
    
    <hr>
    
    <form action="(05b).php" method="post">
        <pre>
            Nama anda : <input type="text" name="nama" size="25"
            maxlength="50">
            <br>
            Email address : <input type="text" name="email" size="25"
            maxlength="50">
            <br>
            Komentar : <textarea name="komentar" cols="40"
            rows="5"> </textarea>
            <br>
            <input type="submit" value="kirim">
            <br>
            <input type="reset" value="ulangi">
        </pre>
    </form>
</body>
</html>