<?php
      
      function reset_vars(){
        global $first_name, $last_name, $birthday, 
               $gender, $email, $ID, $save_update, $info;
        $first_name=null;
        $last_name=null;
        $birthday=null;
        $gender=null;
        $email=null;
        $ID=null;
        //$out=false;
        $info = "";
        $save_update="save";
      }  
      reset_vars(); 
      

      try {
        $conn = new PDO("mysql:host=127.0.0.1; dbname=mydb", "root", null);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo $e->getMessage();
        exit("Keine DB Verbindung!");
      }
      $list_sql="select * from user";
      $param=[null];
      $action="none";
      
      if(isset($_POST['button'])) $action=$_POST['button'];
      switch($action ){
      
        case 'save': 
          $first_name=$_POST['first_name'];
          $last_name=$_POST['last_name'];
          $birthday=$_POST['birthday'];
          $gender=$_POST['gender'];
          $email=$_POST['email'];
          
          if ($first_name=="" or $last_name=="" or $birthday=="" or 
              $email=="" or $gender=="" 
            or array_search($gender,['f','F','M','m'])===false){
            $info="Bitte alle Felder richtig und vollständig ausfüllen!";
            $alert_type="danger";
          }else{
              $sql="INSERT INTO user 
                    (first_name, last_name, birthday, gender, email) 
                    VALUES (?,?,?,?,?)";
              $stmt= $conn->prepare($sql);
              $stmt->execute([$first_name,$last_name,$birthday, $gender, $email]);
              reset_vars(); 
              $info=$stmt->rowCount()." Datensatz angefügt!";
              $alert_type="success";
          }
        break;
        case 'update':
          $first_name=$_POST['first_name'];
          $last_name=$_POST['last_name'];
          $birthday=$_POST['birthday'];
          $gender=$_POST['gender'];
          $email=$_POST['email'];
          $ID=$_POST['ID'];
          //$first_name=="" or $last_name=="" or $birthday=="" or $email==""
              
          if ( !(array_search("",[$first_name,$last_name,$birthday,$email])===false) 
               or array_search($gender,['f','F','M','m'])===false ){
            $info="Bitte alle Felder richtig und vollständig ausfüllen!";
            $alert_type="danger";
            $save_update="update";
          }else{
            $sql="UPDATE user SET first_name=?, last_name=?, birthday=?, gender=?, email=? where ID=?"; 
            $stmt= $conn->prepare($sql);
            $stmt->execute([$first_name,$last_name,$birthday, $gender, $email, $ID]);
            reset_vars();
            $info=$stmt->rowCount()." Datensatz geändert!";
            $alert_type="success";
          }
        break;
        case 'edit':
        
          $save_update="update";
          $ID=$_POST['ID'];
          $sql="SELECT * FROM user WHERE ID=?";
          $stmt = $conn->prepare($sql);
          $stmt->execute([$ID]);
          $row=$stmt->fetch(PDO::FETCH_OBJ);

          $first_name=$row->first_name;
          $last_name=$row->last_name;
          $birthday=$row->birthday;
          $gender=$row->gender;
          $email=$row->email;
          
        break;
        case 'delete':
          $ID=$_POST['ID'];
          $sql="DELETE FROM user WHERE ID=?";
          $stmt = $conn->prepare($sql);
          $stmt->execute([$ID]);
          $info= $stmt->rowCount()." Datensatz gelöscht!";
          $alert_type="success";
        break;  
        case 'search':
          $list_sql="select * from user where (last_name like :search_string) or (first_name like :search_string) or (email like :search_string)";
          $param=['search_string'=>'%'.$_POST['search'].'%'];
      }
      
      //Read
      $stmt= $conn->prepare($list_sql);
      $stmt->execute($param);
      $info_DS="Datensätze: ".$stmt->rowCount();
      $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
      require_once "template.php"; 
      ?>