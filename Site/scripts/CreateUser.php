<?php
    // Autor von CreateUser.php: Daniel Tatzel
    // Erstellt einen neuen Benutzer in der Datenbank
    if ( $_POST['username'] != 'Benutzername')
    {
        //include($_SERVER["DOCUMENT_ROOT"] . "/scripts/ConToDB.php");

        // Baue Verbindung auf
        $dbConnection = ConnectToDB();
            
        $dbConnection->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);

        $query = $dbConnection->prepare("insert into mitglieder (benutzername, geschlecht, vorname, nachname, geburtsdatum, plz, wohnort, strasse, hausnummer, hnrzusatz, email, telefon, sprache) VALUES (:user, :geschlecht, :vorname, :nachname, :geburtsdatum, :plz, :wohnort, :strasse, :hausnummer, :hnrzusatz, :email, :telefon, :sprache);");
        
        $query->bindParam(":user",$_POST['username']);
        
        $query->bindParam(":geschlecht", $_POST['geschlecht']);
            
        $query->bindParam( ":vorname" ,$_POST['vorname'] );
        $query->bindParam( ":nachname", $_POST['nachname'] );
        $GebDatum = $_POST['gebjahr'].$_POST['gebmonat'].$_POST['gebtag'];
        $query->bindParam( ":geburtsdatum", $GebDatum );
        $query->bindParam( ":plz", $_POST['plz'] );
        $query->bindParam( ":wohnort", $_POST['wohnort'] );
        $query->bindParam( ":strasse", $_POST['strasse'] );
        $query->bindParam( ":hausnummer", $_POST['hausnummer'] );
        
        if ( isset( $_POST['hnrzusatz'] ) )
            $query->bindParam( ":hnrzusatz", $_POST['hnrzusatz'] );
        else
            $query->bindParam( ":hnrzusatz", 0);
            
        $query->bindParam( ":email", $_POST['email'] );
        $query->bindParam( ":telefon", $_POST['telefon'] );

        $query->bindParam( ":sprache", $_POST['sprache'] );

        $query->execute();

        $query = $dbConnection->prepare( "insert into login (benutzername, passwort, rolle) VALUES ( :user, :pass, 0)" );
        $query->bindParam( ":user", $_POST['username'] );
        $query->bindParam( ":pass", md5( $_POST['passwd'] ) );
        $query->execute();

        if ( isset( $_POST['tutor'] ) )
        {
            $query = $dbConnection->prepare( "insert into tutor (benutzername, umkreis, stundenlohn, bewertung, gewichtung) VALUES ( :user, :umkreis, :stundenlohn, 0, 0)" );
            $query->bindParam( ":user",$_POST['username']);
            $query->bindParam( ":umkreis", $_POST['umkreis'] );
            $query->bindParam( ":stundenlohn", $_POST['stundenlohn'] );
            $query->execute();
        }

        echo "Registrierung erfolgreich!";

        $dbConnection = null;
    }
?>
