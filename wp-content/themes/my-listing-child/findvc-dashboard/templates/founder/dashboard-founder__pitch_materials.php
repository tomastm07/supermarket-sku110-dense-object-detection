<?php
/**
 * Dashboard Founder - Pitch Materials
 */

$get_pdficon  = GET_IMG . 'pdf.svg';
$get_playbtn  = GET_IMG . 'playbtn.svg';

?>
<style>
	table {
		width: 90%;
		box-shadow: 0px 5px 40px rgba(0, 0, 0, 0.05);
	}
	table tr,th{
		padding: 2rem;
		font-weight: 100;
	}
	table tr{
		border-bottom: 1px solid #bfbfbf;
	}
	table tr:first-child, tr:last-child{
		border-bottom: none!important;
	}
	.titles th{
		font-weight: 700;
		background-color: #F6F7FB;
	}
	#upload-section{
		margin-top: 10rem;
	}
	#upload-section h5{
		font-weight: 300;
	}
	#upload-section input[type=file]{
		border: 1px dashed #000;
		max-width: 50%;
		padding: 1rem;
	}
	#upload-section input[type=file]::file-selector-button{
		padding: 10px 25px;
		width: 160px;
		height: 42px;
		background: #E53E52;
		border-radius: 5px;
		color: #fff;
		border: none;
		margin-right: 2rem;
	}
	#buttons-section{
		display: flex; 
		flex-direction: row; 
		vertical-align: center;
	}
	#buttons-section button{
		color: #fff;
		background-color: #000;
		padding: .5rem 5rem;
		border-radius: 5px;
		margin-left: 3rem;
	}
</style>
<section class="content">
	<div class="base-card container">
		<div class="wd-100">
            <section class="left-side">
                <?php get_template_part('findvc-dashboard/templates-parts/dashboard-menu'); ?>
            </section>
			<section class="right-side">
				<h4>Pitch Bank</h4>
                <div class="main-info-container">
                    <div class="first-text-block">
                    </div>
                </div>
				<table>
				<tr class="titles">
					<th>Pitch Deck</th>
					<th>File Format</th>
					<th>File Size</th>
					<th>Contact Date</th>
					<th>Actions</th>
				</tr>
				<tr>
					<th><img width="15" height="15" src="<?php echo $get_pdficon; ?>"> pitch_deck_0123</th>
					<th>PDF</th>
					<th>8mb</th>
					<th>07-26-22, 12:56:12</th>
					<th><div style="display: flex; flex-direction: row; vertical-align: center;"><button>X</button><button>X</button><button>X</button><button>X</button></div></th>
				</tr>
				<tr>
				<th><img width="15" height="15" src="<?php echo $get_playbtn; ?>"> pitch_video_0125</th>
					<th>Video</th>
					<th>8mb</th>
					<th>07-22-22, 12:56:12</th>
					<th><div style="display: flex; flex-direction: row; vertical-align: center;"><button>X</button><button>X</button><button>X</button><button>X</button></div></th>
				</tr>
				</table>
				<form id="upload-section" action="">
				<h4>You Can Upload Here</h4>
					<h5>Click on the button or drag & drop files here</h5>
					<div id="buttons-section">
						<input type="file" name="" id="">
						<button>Submit File</button>
					</div>
				</form>
            </section>
		</div>
	</div>
</section>

<?php
?>