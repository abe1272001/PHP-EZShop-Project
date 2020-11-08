<?php

class CreateDb
{
  public $servername;
  public $username;
  public $password;
  public $dbname;
  public $tablename;
  public $link;
  //tablename = products table
  //users table
  //orders table
  //carts table

  //construct 
  public function __construct(
    $dbname = "Newdb",
    $tablename = "producttb",
    $servername = "localhost",
    $username = "root",
    $password = "root"
  ) {
    $this->dbName = $dbname;
    $this->tablename = $tablename;
    $this->servername = $servername;
    $this->username = $username;
    $this->password = $password;

    //建立連線和檢查
    $this->link = mysqli_connect($servername, $username, $password) or die("Connection failed:" . mysqli_connect_error());

    //若$dbName不存在，則建立db
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

    // 若成功建立新資料庫，則創建new table
    if (mysqli_query($this->link, $sql)) {
      $this->link = mysqli_connect($servername, $username, $password);
      mysqli_select_db($this->link, $dbname);

      //sql to create new table 
      $sql = "CREATE TABLE IF NOT EXISTS $tablename
            (ProductID int auto_increment  primary key,
            ProductName varchar(50) NOT NULL,
            ProductDesc varchar(250) default NULL,
            ProductPrice int,
            CatagoryID int default NULL,
            ProductImage varchar(100) default NULL);";

      $sql_user = "
      CREATE TABLE IF NOT EXISTS users
            (UserID int auto_increment  primary key,
            UserName varchar(250) NOT NULL,
            UserEmail varchar(250) NOT NULL,
            UserPassword varchar(250) NOT NULL,
            UserPhone varchar(50) NOT NULL,
            UserAddress varchar(300) NOT NULL);
      ";

      $sql_orders = "
      CREATE TABLE IF NOT EXISTS orders
      (OrderID int auto_increment primary key,
      CustomerID varchar(100) DEFAULT NULL,
      ShipName varchar(100) NOT NULL,
      ShipAddress varchar(300) NOT NULL,
      ShipPhone varchar(50) NOT NULL,
      ShipPayment varchar(100) DEFAULT NULL);
      ";

      $sql_orderdetails = "
      CREATE TABLE IF NOT EXISTS orderdetails
      ( OrderID int,
        ProductID int,
        UnitPrice int,
        Quantity int(6),
        Discount float
      )
      ";
      //若query失敗
      if (!mysqli_query($this->link, $sql)) {
        echo "Error creating table:" . mysqli_error($this->link);
      }

      if (!mysqli_query($this->link, $sql_user)) {
        echo "Error creating table:" . mysqli_error($this->link);
      }

      if (!mysqli_query($this->link, $sql_orders)) {
        echo "Error creating table:" . mysqli_error($this->link);
      }

      if (!mysqli_query($this->link, $sql_orderdetails)) {
        echo "Error creating table:" . mysqli_error($this->link);
      }
    } else {
      return false;
    }
  }

  //get product from db
  public function getProductData()
  {
    $sql =
      "select * FROM $this->tablename";
    $result = mysqli_query($this->link, $sql);
    if (mysqli_num_rows($result) > 0) {
      return $result;
    }
  }

  //get order from db
  public function getOrderData()
  {
  }
  //get user from db
  public function getUserData()
  {
    $sql = "select * FROM users";
    $result = mysqli_query($this->link, $sql);
    if (mysqli_num_rows($result) > 0) {
      return $result;
    }
  }
}