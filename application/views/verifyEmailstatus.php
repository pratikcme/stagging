<!DOCTYPE html>
<html>
<head>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="icon" href="<?=$this->siteLogo?>" type="image/gif" sizes="8x8">
<link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Cabin&display=swap" rel="stylesheet">
	<title></title>
	<style type="text/css">
		body{
			height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;	
			text-align: center;
			overflow: hidden;		
		}
		img {
			width: 400px;
		}
		h1 {
			font-size: 40px; 
			margin: 0px;
			color: #fff;
			line-height: 50px;
			margin-top: 20px;
			font-family: 'Sansita Swashed', cursive;
			    font-weight: 100;
		}
		span{
			font-family: 'Cabin', sans-serif;
			font-size:35px; 
			color: black;
		}
	</style>
</head>
<body>
		<div>
				<img src="<?=$this->siteLogo?>">
				 <?php echo $this->session->flashdata('myMessage'); ?>
				
		</div>
</body>
</html>