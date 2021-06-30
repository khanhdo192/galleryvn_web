<?php
/**
 * @Author	HaiNM - VietTuongTac - BreadnTea
 * @Mail	nguyenminhhai@breadntea.vn
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class VTT_TemplateEmail {

	public static $_instance = null;
	
	private $name = '';
	
	private $logo = null;

	// Private methods cannot be called
	private function __construct()
	{
		$primaryLogo = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
		
		$this->name = 'GalleryVN';
		$this->logo = $primaryLogo[0];
	}
	
	// Private methods cannot be called
	private function __clone() {}
	
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function buildHTML($content1, $content2, $content3)
	{
		$content = $content1 . $content2 . $content3;
		
		$logo = $this->logoTemp();
		$title = $this->titleTemp();
		$footer = $this->footerTemp();
		$content = $logo . $title . $content . $footer;
		$result = $this->defaultHMTL($content);
		return $result;
	}
	
	public function handleTemp($_text = '', $_data = [])
	{
		$html = '';
		
		if(empty($_data) || count($_data) < 1){
			return $html;
		};
		
		$html .= '<tr><td align="center" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="font-size:0; line-height: 0; padding: 10px;">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" valign="center">
						<h3 style="font-size: 14px; color: #252525; text-transform: uppercase;">'. ($_text) .'</h3>
					</td>
				</tr>
			</table>';
		foreach ($_data as $value){
			$html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
			$html .= '<tr>';
			$html .= '<td align="left" valign="top">';
			$html .= '<p style="font-size:0; line-height: 0; margin: 10px 0; padding:0; border-bottom: 1px solid #ddd;"></p>';
			$html .= '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td align="left" valign="top">';
			$html .= '<ul style="margin: 0; padding-left: 30px;">';
			if(!empty($value['post_title'])){
				$html .= '<li><p style="font-size: 14px; color: #252525;">Tác phẩm: '. ($value['post_title']) .'</p></li>';
			}
			$html .= '<li><p style="font-size: 14px; color: #252525;">Họ và tên: '. ($value['name']) .'</p></li>';
			$html .= '<li><p style="font-size: 14px; color: #252525;">Email: '. ($value['email']) .'</p></li>';
			$html .= '<li><p style="font-size: 14px; color: #252525;">Số điện thoại: '. ($value['phone']) .'</p></li>';
			$html .= '<li><p style="font-size: 14px; color: #252525;">Lời nhắn: '. ($value['messenger']) .'</p></li>';
			$html .= '<li><p style="font-size: 14px; color: #252525;">Thời gian: '. ($value['created_at']) .'</p></li>';
			$html .= '</ul>';
			$html .= '</td>';
			$html .= '</tr>';
			$html .= '</table>';
		};
		$html .= '</td></tr>';
		
		return $html;
	}
	
	private function titleTemp()
	{
		return '<tr>
			<td align="center" valign="top">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td align="left" valign="center">
							<h2 style="font-size: 18px; color: #252525; text-align: center; font-weight: normal; text-transform: uppercase;">Danh sách thông tin khách hàng</h2>
						</td>
					</tr>
				</table>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="font-size:0; line-height: 0; padding: 20px;">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>';
	}

	private function logoTemp()
	{
		return '<tr>
			<td align="center" valign="top">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="100%" align="center" valign="center">
							<img src="'. ($this->logo) .'" border="0" alt="'. ($this->name) .'" style="margin:0; padding:0; display:block; max-width: 100%; max-height: 52px;" />
						</td>
					</tr>
				</table>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="font-size:0; line-height: 0; padding: 20px;">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>';
	}

	private function footerTemp()
	{
		return '<tr>
			<td>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="font-size:0; line-height: 0; padding: 30px;">&nbsp;</td>
					</tr>
				</table>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td align="left" valign="top">
							<p style="font-size:0; line-height: 0; margin: 10px 0; padding:0; border-bottom: 1px solid #ddd;"></p>
						</td>
					</tr>
				</table>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td align="left" valign="center">
							<p style="font-size: 13px; color: #8f8f8f;"><i>Hãy liên hệ với khách hàng sớm nhất, chúc bạn một ngày tốt lành!</i></p>
						</td>
					</tr>
				</table>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="font-size:0; line-height: 0; padding: 5px;">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>';
	}
	
	private function defaultHMTL( $content = ''){
		return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>'. $this->name .'</title>
		<style type="text/css">
			/* CLIENT-SPECIFIC STYLES */
			body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
			table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
			img { -ms-interpolation-mode: bicubic; }

			/* RESET STYLES */
			:root {
				font-size: 62.5%;
			}
			html, div, span, table, tbody, tfoot, thead, tr, th, td {
				margin: 0;
				padding: 0;
				border: 0;
			}
			img { border: none; outline: none; text-decoration: none; }
			table { border-collapse: collapse !important; margin: 0; }
			body { margin: 0 !important; padding: 0 !important; width: 100% !important; }

			/* iOS BLUE LINKS */
			a[x-apple-data-detectors] {
				color: inherit !important;
				text-decoration: none !important;
				font-size: inherit !important;
				font-family: inherit !important;
				font-weight: inherit !important;
				line-height: inherit !important;
			}
			
			/* ANDROID CENTER FIX */
			div[style*="margin: 16px 0;"] { margin: 0 !important; }
			
			/* default */
			h1, h2, h3, h4, h5, h6, p, strong, u, b, i
			{
				font-family: Roboto,Helvetica,Aria,sans-serif;
				word-break: break-word;
				line-height: 1.5;
				text-align: left;
				letter-spacing: 0.2px;
			}
			h1, h2, h3, h4, h5, h6
			{
				margin: 0;
			}
			p{
				display: block;
				margin: 0;
				padding: 2px 0;
			}
			
		</style> 
	</head>
	<body style="margin:0; padding:0; background-color:#6a6a6a;"><center>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#6a6a6a" style="background-color:#6a6a6a;">
			<tr>
				<td align="center" valign="top">
					<table width="800" cellpadding="0" cellspacing="0" border="0" bgcolor="#fff" style="background-color: #fff; max-width: 800px; width: 100%;">
						<tr>
							<td align="center" valign="top">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td style="font-size:0; line-height: 0; padding: 15px;">&nbsp;</td>
									</tr>
								</table>
							<td>
						</tr>
						<tr>
							<td align="center" valign="top">
								<table width="640" cellpadding="0" cellspacing="0" border="0" style="max-width: 640px; width: 100%;">
									' .($content). '
								</table>
							</td>
						</tr>
						<tr>
							<td align="center" valign="top">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td style="font-size:0; line-height: 0; padding: 15px;">&nbsp;</td>
									</tr>
								</table>
							<td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</center></body>
</html>';
	}
}