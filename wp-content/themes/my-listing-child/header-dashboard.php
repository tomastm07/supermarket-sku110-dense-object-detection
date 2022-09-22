<!DOCTYPE html>
<html lang="en">
<head>
	<?php wp_head(); ?>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php wp_title(); ?></title>
</head>

<?php
$get_logo        = GET_IMG . 'logo.svg';
$get_search_icon = GET_IMG . 'search-icon.svg';
$get_notify_icon = GET_IMG . 'notify-icon.svg';
$get_avatar_icon = GET_IMG . 'avatar.png';
?>

<body>
	<main class="primary-content">
		<header class="header__content">
			<div class="container">
				<nav class="navbar-founder__dashboard">
					<figure class="navbar-founder__logo"><img class="navbar-founder__logo--item" src="<?php echo esc_url( $get_logo ); ?>" alt="Logo FindVC-Dashboard" loading="lazy"></figure>
					<div class="navbar-founder__dashboard__menu">
					<?php
					/*
						wp_nav_menu(
							array(
								'theme_location'  => 'founder_menu',
								'container_class' => 'founder_menu__container',
							)
						);
					*/
					?>
					</div>
					<div class="navbar-founder__dashboard--toggles">
						<div class="navbar-founder__dashboard__search">
							<label for="search">
								<input type="search" placeholder="Search">
								<img src="<?php echo esc_url( $get_search_icon ); ?>" alt="search-icon" loading="lazy">
							</label>
						</div>
						<div class="navbar-founder__dashboard__notify">
							<button class="navbar-founder__dashboard__notify--btn">
								<img src="<?php echo esc_url( $get_notify_icon ); ?>" alt="notify-icon" loading="lazy">
							</button>
						</div>
						<div class="navbar-founder__dashboard__avatar">
							<figure class="navbar-founder__dashboard__avatar--item">
								<img src="<?php echo esc_url( $get_avatar_icon ); ?>" alt="avatar-icon" loading="lazy">
							</figure>
						</div>
					</div>
				</nav>
			</div>
		</header>
	</main>
