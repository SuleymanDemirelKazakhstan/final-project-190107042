<?php  
	class Toon{
		private $server = "localhost";
		private $username = "root";
		private $password;
		private $db = "webtoon_kz";
		private $conn;
		
		public $phpFileUploadErrors = array(
			0 => 'There is no error, the file uploaded with succes',
			1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
			2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
			3 => 'The uploaded file was only partialy uploaded',
			4 => 'No file was uploaded',
			6 => 'Missing a temporary folder',
			7 => 'Failed to write file to disc.',
			8 => 'A PHP extension stopped the file upload.'
			);

		public function __construct(){
			try {
				$this->conn = new mysqli($this->server,$this->username,$this->password,$this->db);
			} catch (Exception $e) {
				echo "connection failed" . $e->getMessage();
			}
		}

		public function insert(){
			if (isset($_POST['submit'])) {
				if (isset($_POST['name']) && isset($_POST['altname']) && isset($_POST['author']) && isset($_POST['description']) && isset($_POST['year']) && isset($_POST['status']) && isset($_POST['genre'])) {

	  				$target_file = basename($_FILES["picture"]["name"]);

	  				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	  				$extensions_arr = array("jpg","jpeg","png");


					if (!empty($_POST['name']) && !empty($_POST['altname']) && !empty($_POST['author']) && !empty($_POST['description']) && !empty($_POST['year']) && !empty($_POST['status']) && !empty($_POST['genre']) && in_array($imageFileType,$extensions_arr)) {


						$name = $_POST['name'];
						$altname = $_POST['altname'];
						$description = $_POST['description'];
						$author = $_POST['author'];
						$year = $_POST['year'];
						$status = $_POST['status'];
						
						$genre = "";
						foreach($_POST['genre'] as $gen){
							$genre = $genre.$gen." ";
				        }

						$query = "INSERT INTO toons (name, altname, author, description,  year, status, genre) VALUES ('$name', '$altname', '$author', '$description', '$year', '$status', '$genre')";
						

						if ($sql = $this->conn->query($query)) {

							$last_id = $this->conn->insert_id;

							$dir = "toons/$last_id/";

							$query = "UPDATE toons SET img_dir = '$dir"."img.$imageFileType' WHERE id = '$last_id'";
							$this->conn->query($query);

							mkdir($dir);
							$srcFile = 'partials/toon/index.php';
							$destination = $dir."index.php";
							copy($srcFile, $destination);
							
							move_uploaded_file($_FILES['picture']['tmp_name'],$dir."img.".$imageFileType);
							echo "<script>window.location.href = '$dir'</script>";
						}
					}
				}
		  		
			}
		}
		public function updateToon($id){

			if (isset($_POST['submit'])) {
				if (isset($_POST['name']) && isset($_POST['altname']) && isset($_POST['author']) && isset($_POST['description']) && isset($_POST['year']) && isset($_POST['status']) && isset($_POST['genre'])) {

					if (!empty($_POST['name']) && !empty($_POST['altname']) && !empty($_POST['author']) && !empty($_POST['description']) && !empty($_POST['year']) && !empty($_POST['status']) && !empty($_POST['genre'])) {
						$name = $_POST['name'];
						$altname = $_POST['altname'];
						$description = $_POST['description'];
						$author = $_POST['author'];
						$year = $_POST['year'];
						$status = $_POST['status'];
						
						$genre = "";
						foreach($_POST['genre'] as $gen){
							$genre = $genre.$gen." ";
				        }

				        $query = "UPDATE toons SET name = '$name', altname = '$altname', author = '$author', description = '$description',  year = '$year', status = '$status', genre = '$genre' WHERE id = '$id'";
				        
						if ($sql = $this->conn->query($query)) {
							$dir = "toons/$id/";	
							if (isset($_POST['picture']) && $_POST['picture']['name']) {
					        	$target_file = basename($_FILES["picture"]["name"]);

				  				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				  				$extensions_arr = array("jpg","jpeg","png");

				  				if(in_array($imageFileType,$extensions_arr)){
				  					

				  					$toon = $this->getToonById($id);
				  					$oldImg = $_SERVER['DOCUMENT_ROOT']."/".$toon['img_dir'];
				  					
				  					$query = "UPDATE toons SET img_dir = '$dir"."img.$imageFileType' WHERE id = '$id'";
									if($this->conn->query($query)){
										unlink($oldImg);
										move_uploaded_file($_FILES['picture']['tmp_name'],$dir."img.".$imageFileType);
									}
				  				}
					        }
							echo "<script>window.location.href = '../../$dir'</script>";
						}
					}else{
						echo "<script>alert('error')</script>";
					}
				}else{
					echo print_r($_POST);
				}
		  		
			}
		}

		public function reArrayFiles($file_post){
			$file_ary = array();
			$file_count = count($file_post['name']);
			$file_keys = array_keys($file_post);

			for ($i=0; $i < $file_count; $i++) { 
				foreach ($file_keys as $key) {
					$file_ary[$i][$key] = $file_post[$key][$i];
				}
			}

			return $file_ary;
		}

		public function addChapter($id){
			$dir = $_SERVER['DOCUMENT_ROOT'];
			if (isset($_POST['submit']) && isset($_FILES['pictures']) && isset($_POST['name']) && (!empty($_POST['name']) || $_POST['name']=='0') ) {
				$file_array = $this->reArrayFiles($_FILES['pictures']);
			 	
			 	$cdir = $dir."/toons/".$id."/".$_POST['name']."/";
			 	mkdir($cdir);

			 	$srcFile = $dir.'/partials/reader/index.php';
				$destination = $cdir."index.php";
				copy($srcFile, $destination);

				$myJson = fopen($cdir."chapter.json", "w");

				$toon = $this->getToonById($id);
				$tmp = explode(";",  $toon['chapters']);
				$prevCh = end($tmp);
				echo $prevCh;

				$chObj = new chapter;
				

			 	for ($i=0; $i < count($file_array); $i++) { 
					if ($file_array[$i]['error']) {
						?>
							<div class="allert">
								<?php echo $file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']] ?>
							</div>
						<?php
					}else {
						$extensions = array('jpg', 'png', 'jpeg');
						$file_ext = explode('.', $file_array[$i]['name']);
						$file_ext = end($file_ext);

						if (!in_array($file_ext, $extensions)) {
							?>
								<div class="allert">
									<?php echo "{$file_array[$i]['name']} - invalid file extension!" ?>
								</div>
							<?php
						}
						else{
							if(move_uploaded_file($file_array[$i]['tmp_name'], $cdir.$file_array[$i]['name'])){
								array_push($chObj->images, $file_array[$i]['name']);
							}

						}
					}
				}
				$d = $toon['chapters'];
				if(!empty($toon['chapters']) || $toon['chapters']=='0'){
					$d = $d.";";
				}

				$newChapter = $d.$_POST['name'];
				$query = "UPDATE toons SET chapters = '$newChapter' WHERE id = '$id'";
				$this->conn->query($query);
				
				if(isset($prevCh) && (!empty($prevCh) || $prevCh=='0')){
					$chObj->prev = $prevCh;
					$prevJson = json_decode( file_get_contents($dir."/toons/".$id."/".$prevCh."/chapter.json"), true );

					$prevJson['next'] = $_POST['name'];
					echo $prevCh;
					file_put_contents($dir."/toons/".$id."/".$prevCh."/chapter.json", json_encode($prevJson));
				}

				fwrite($myJson, json_encode($chObj));
				fclose($myJson);
			} 
		}

		public function search($s){
			$data = null;

			$query = "SELECT * FROM toons WHERE CONVERT(`name` USING utf8) LIKE '%".$s."%' OR CONVERT(`name` USING utf8) LIKE '%".$s."%'";
				
			if ($sql = $this->conn->query($query)) {
				while ($toon = mysqli_fetch_assoc($sql)) {
					$data[] = $toon; 		
				} 	
			}
			return $data;

		}

		public function getGenres(){
			$data = null;

			$query = "SELECT * FROM genres";
			if ($sql = $this->conn->query($query)) {
				while ($toon = mysqli_fetch_assoc($sql)) {
					$data[] = $toon; 		
				} 	
			} 
			return $data;
		}

		public function getGenName($alt){
			$data = null;

			$query = "SELECT * FROM genres WHERE altname = '$alt'";
			if ($sql = $this->conn->query($query)) {
				$data = mysqli_fetch_assoc($sql);
			} 
			if(isset($data['name']))
				return $data['name'];
		}

		public function getToonById($id){
			$data = null;

			$query = "SELECT * FROM toons WHERE id = '$id'";
			if ($sql = $this->conn->query($query)) {
				$data = mysqli_fetch_assoc($sql);
			} 
			return $data;
		}
		public function bookmarkToon($id){
			$data = null;
			$query = "SELECT * FROM toons WHERE id = '$id'";
			if ($sql = $this->conn->query($query)) {
				$data = mysqli_fetch_assoc($sql);
			} 

			$tmp = 1 - $data['fav'];

			$query = "UPDATE toons SET fav = '$tmp' WHERE id = '$id'";
			if ($sql = $this->conn->query($query)) {
				echo "<script>alert('success')</script>";
			} 
		}
		public function fetch(){
			$data = null;

			$query = "SELECT * FROM toons";
			if ($sql = $this->conn->query($query)) {
				while ($toon = mysqli_fetch_assoc($sql)) {
					$data[] = $toon; 		
				} 	
			} 
			return $data;
		}
		
		public function delete($id){
			$dir = $_SERVER['DOCUMENT_ROOT'];

			$dirPath = $dir."/toons/".$id;

			$query = "DELETE FROM toons where id = '$id'";
			if ($sql = $this->conn->query($query)) {
				$this->deleteDir($dirPath);
				return true;
			}
			else{
				return false;
			}
		}
		public function deleteDir($dirPath) {
		    if (! is_dir($dirPath)) {
		        throw new InvalidArgumentException("$dirPath must be a directory");
		    }
		    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
		        $dirPath .= '/';
		    }
		    $files = glob($dirPath . '*', GLOB_MARK);
		    foreach ($files as $file) {
		        if (is_dir($file)) {
		            self::deleteDir($file);
		        } else {
		            unlink($file);
		        }
		    }
		    rmdir($dirPath);
		}
	}
	

	class chapter{
	    public $prev = "";
	    public $next = "";
		public $images = [];
	}
?>