<?php

    include_once "DBconnect.php";
    session_start();

            
               
            $_SESSION['search_item'] = $_POST['searchedISBN'];

            

            if(isset($_POST['deleteSearched'])){
                $_SESSION['search_item'] = $_POST['searchedISBN'];
                $isbn = $_SESSION['search_item'];

                $sqlDel = "DELETE FROM `book` WHERE ISBN_No = '$isbn'; ";
                
    
                if ($mysqli->query($sqlDel) === true) {
                    $_SESSION['message'] = "Book Deleted successfully";
                    header("Location: Admin_Book_Manager.php");
                    exit(0);
                } else {
                    $_SESSION['message'] = "Something Went Wrong";
                    header("Location: Admin_Book_Manager.php");
                    exit(0);
                }
            }
            
                    
                    
               
            

            
           
 





            // check if submit button is pressed 
            if (isset($_POST["submitU"])) {
                //image uploading
                $fileName = $_FILES["imageU"]["name"];
                $filePath = ""; 
                if (!empty($fileName) && $_FILES["imageU"]["error"] === UPLOAD_ERR_OK) {
                    $uploadDirectory = "up/";
                    $filePath = $uploadDirectory . $fileName;
                    //moving the uploaded file 

                    if (move_uploaded_file($_FILES["imageU"]["tmp_name"], $filePath)) {
                       
                    } else {
                        echo "Error uploading image.";
                       
                    }
                }

                //data adding from form
               
                $bookName = $_POST["book_NameU"];
                $bookPrice = $_POST["book_PriceU"];
                $language = $_POST["lngU"];
                $publisher = $_POST["pubU"];
                $author = $_POST["autNameU"];
                $category = $_POST["catgryU"];
                $publishDate = $_POST["pudateU"];
                $stockedBook = $_POST["act_StockU"];
                $book_id = $_SESSION['search_item'];

                
                if (!empty($fileName) &&  !empty($bookName)
                && !empty($bookPrice) && !empty($language) 
                && !empty($publisher) && !empty($author) 
                && !empty($category) && !empty($publishDate) 
                && !empty($stockedBook)) {


                // Update the database
                $updateQuery = "UPDATE book
                    SET 
                    Image_name = ?,
                    image_url = ?,
                    Book_name = ?,
                    Book_Price = ?,
                    `Language` = ?,
                    publisher_fk = ?,
                    author_fk = ?,
                    category_fk = ?,
                    Publish_date = ?,
                    Stocked_Books = ?
                    WHERE ISBN_No = ?";

                
                if ($stmt = $mysqli->prepare($updateQuery)) {
                    // Bind the parameters
                    $stmt->bind_param(
                        "sssdssdddsd",
                        $fileName,
                        $filePath,
                        $bookName,
                        $bookPrice,
                        $language,
                        $publisher,
                        $author,
                        $category,
                        $publishDate,
                        $stockedBook,
                        $book_id
                    );

                    // Execute the statement
                    if ($stmt->execute()) {
                        $_SESSION['messg'] = "Book Updated successfully";
                        header("Location:Admin_Book_Manager.php");
                       exit(0);
                    } else {
                        $_SESSION['message'] = "Something Went Wrong";
                        header("Location:Admin_Book_Manager.php");
                       exit(0);
                    }
                }   

                   
                    
                } else {
                    $_SESSION['message'] = "Fields cannot be empty";
                    header("Location:Admin_Book_Manager.php");
                  exit(0);
         
                }
            }



                   
?>