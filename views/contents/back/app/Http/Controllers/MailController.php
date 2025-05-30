<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\Correos_Recibidos;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller
{
    //
    private $emailSender = 'consulta.milagrodevida@gmail.com';
    private $passSender = 'ygfyrqkpwkolswdj';
    private $smtp = 'smtp.gmail.com';
    private $port = 465;

    
    protected $email;
    protected $nombre;
    protected $titulo;

    
    public function __construct($email, $nombre){
        $this->email = $email;
        $this->nombre = $nombre;
    }

    public function sedMailCita(Citas $cita){

        $mail = new PHPMailer(true);

        try{

            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $this->smtp;                            //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $this->emailSender;                     //SMTP username
            $mail->Password   = $this->passSender;                      //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = $this->port;                            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($this->emailSender, 'Consultorio Obstetrico Milagro de Vida');
            $mail->addAddress($this->email, $this->nombre);     //Add a recipient
            $mail->addReplyTo('info@example.com', 'Cita generada');

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Cita agendada para ' . $cita->fecha . ' a las ' . $cita->doctor_horario->hora_inicio;

            $mail->Body = '
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#e5e5e5" id="bodyTable">
				<tbody>
					<tr>
						<td style="padding-right:10px;padding-left:10px;" align="center" valign="top" id="bodyCell">

							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperBody" style="max-width:600px">
								<tbody>
									<tr>
										<td align="center" valign="top">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableCard" style="background-color:#fceffc;border-color:#e9afe7;border-style:solid;border-width:0 1px 1px 1px;">
												<tbody>
													<tr>
														<td style="background-color:#00d2f4;font-size:1px;line-height:3px" class="topBorder" height="3">&nbsp;</td>
													</tr>
													<tr>
														<td style="padding-top: 45px; padding-bottom: 20px;" align="center" valign="middle" class="emailLogo">
															<h2>CONSULTORIO OBSTETRICO MILAGRO DE VIDA</h2>
														</td>
													</tr>

													<tr>
														<td style="padding-bottom: 15px;" align="center" valign="top" class="imgHero">

														<a href="https://ibb.co/C3VT1YW8"><img src="https://i.ibb.co/JwrMBGCt/LOGO-OBS.png" style="width: 150px; height:150px" alt="LOGO-OBS" border="0"></a>
														</td>
													</tr>
													<tr>
														<td style="padding-bottom: 5px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="mainTitle">
															<h2 class="text" style="color:#000;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:28px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:36px;text-transform:none;text-align:center;padding:0;margin:0">
															Hola "'. $this->nombre.'"
															</h2>
														</td>
													</tr>
													<tr>
														<td style="padding-bottom: 30px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="subTitle">
															<h4 class="text" style="color:#999;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:24px;text-transform:none;text-align:center;padding:0;margin:0">
															Tienes una nueva cita agendada</h4>
														</td>
													</tr>
													<tr>
														<td style="padding-left:20px;padding-right:20px" align="center" valign="top" class="containtTable ui-sortable">
															<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription" style="">
																<tbody>
																	<tr>
																		<td style="padding-bottom: 20px;" align="center" valign="top" class="description">
																			<p class="text" style="color:#666;font-family:"Open Sans",Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:22px;text-transform:none;text-align:center;padding:0;margin:0">
																			Estimado Paciente <b>'.$this->nombre.'</b>, le recordamos que su cita médica ha sido agendada para el dia  <b>'. $cita->fecha.'</b> a las <b>'. $cita->doctor_horario->hora_inicio .' </b>.
																			</p>

																			<p class="text" style="color:#666;font-family:"Open Sans",Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:22px;text-transform:none;text-align:center;padding:0;margin:0">
																			Con el Dr/Dra. . <b>'. $cita->doctor->persona->nombre. ' ' .$cita->doctor->persona->apellido .' </b> en el area de: <b>' .$cita->doctor->especialidades->nombre_especialidad .' </b>
																	 
																			</p>

																			<p></p>
																			<p class="text" style="color:#666;font-family:"Open Sans",Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:22px;text-transform:none;text-align:center;padding:0;margin:0">
																				Por favor asistir unos minutos antes
																			</p>




																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td style="font-size:1px;line-height:1px" height="20">&nbsp;</td>
													</tr>
												</tbody>
											</table>
											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
												<tbody>
													<tr>
														<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperFooter" style="max-width:600px">
								<tbody>
									<tr>
										<td align="center" valign="top">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
												<tbody>
													<tr>
														<td style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px" align="center" valign="top" class="socialLinks">
															<a href="https://www.facebook.com/profile.php?id=61567128084668" style="display:inline-block" target="_blank" class="facebook">
																<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/facebook.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
															</a>
														
															<a href="#instagram-link" style="display: inline-block;" target="_blank" class="instagram">
																<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/instagram.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
															</a>
														 
														</td>
													</tr>
						<p class="text" style="color:#666;font-family:"Open Sans",Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:22px;text-transform:none;text-align:center;padding:0;margin:0">
																			Consultorio	Milagro de vida, cuidamos tu salud 
																			</p>


													<tr>
														<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
									<tr>
										<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>';

            $mail->send();
            // echo "Mail sended :v";
            return true;
        }
        catch(Exception $e){
            echo $e->errorMessage();
            return false;
        }
    }



	public function sedMailCita2(Correos_Recibidos $corr){

        $mail = new PHPMailer(true);

        try{

            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $this->smtp;                            //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $this->emailSender;                     //SMTP username
            $mail->Password   = $this->passSender;                      //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = $this->port;                            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($this->emailSender, 'G.R.A.C');
            $mail->addAddress($this->email, $this->nombre);     //Add a recipient
            $mail->addReplyTo('info@example.com', 'Cita generada');

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Cita agendada para ' . $corr->fecha . ' a las ' . $corr->hora;

            $mail->Body = '
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#f9f9f9" id="bodyTable">
				<tbody>
					<tr>
						<td style="padding-right:10px;padding-left:10px;" align="center" valign="top" id="bodyCell">

							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperBody" style="max-width:600px">
								<tbody>
									<tr>
										<td align="center" valign="top">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableCard" style="background-color:#fff;border-color:#e5e5e5;border-style:solid;border-width:0 1px 1px 1px;">
												<tbody>
													<tr>
														<td style="background-color:#00d2f4;font-size:1px;line-height:3px" class="topBorder" height="3">&nbsp;</td>
													</tr>
													<tr>
														<td style="padding-top: 60px; padding-bottom: 20px;" align="center" valign="middle" class="emailLogo">
															<h2>CORSANO</h2>
														</td>
													</tr>

													<tr>
														<td style="padding-bottom: 15px;" align="center" valign="top" class="imgHero">

															<a href="https://ibb.co/yV47j29"><img src="https://i.ibb.co/stWzY7f/Captura.jpg" alt="Captura" border="0"></a>
														</td>
													</tr>
													<tr>
														<td style="padding-bottom: 5px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="mainTitle">
															<h2 class="text" style="color:#000;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:28px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:36px;text-transform:none;text-align:center;padding:0;margin:0">
															Hola "'. $this->nombre.'"
															</h2>
														</td>
													</tr>
													<tr>
														<td style="padding-bottom: 30px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="subTitle">
															<h4 class="text" style="color:#999;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:24px;text-transform:none;text-align:center;padding:0;margin:0">
															Tienes una nueva cita agendada</h4>
														</td>
													</tr>
													<tr>
														<td style="padding-left:20px;padding-right:20px" align="center" valign="top" class="containtTable ui-sortable">
															<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription" style="">
																<tbody>
																	<tr>
																		<td style="padding-bottom: 20px;" align="center" valign="top" class="description">
																			<p class="text" style="color:#666;font-family:"Open Sans",Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:22px;text-transform:none;text-align:center;padding:0;margin:0">
																			Estimado Paciente <b>'.$this->nombre.'</b>, le recordamos que su cita médica ha sido agendada para el dia  <b>'. $corr->fecha.'</b> a las <b>'. $corr->hora .' </b>.
																			</p>

																			<p class="text" style="color:#666;font-family:"Open Sans",Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:22px;text-transform:none;text-align:center;padding:0;margin:0">
																			Con el Dr/Dra. . <b>'. $corr->medico. '  </b> en el area de: Cardiologia <b> </b>
																	 
																			</p>

																			<p></p>
																			<p class="text" style="color:#666;font-family:"Open Sans",Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:22px;text-transform:none;text-align:center;padding:0;margin:0">
																				Por favor asistir con 15 minutos de anticipación y evitar retrasos
																				. <b>'. $corr->observacion. ' 
																			</p>




																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td style="font-size:1px;line-height:1px" height="20">&nbsp;</td>
													</tr>
												</tbody>
											</table>
											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
												<tbody>
													<tr>
														<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperFooter" style="max-width:600px">
								<tbody>
									<tr>
										<td align="center" valign="top">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
												<tbody>
													<tr>
														<td style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px" align="center" valign="top" class="socialLinks">
															<a href="#facebook-link" style="display:inline-block" target="_blank" class="facebook">
																<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/facebook.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
															</a>
															<a href="#twitter-link" style="display: inline-block;" target="_blank" class="twitter">
																<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/twitter.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
															</a>
															<a href="#pintrest-link" style="display: inline-block;" target="_blank" class="pintrest">
																<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/pintrest.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
															</a>
															<a href="#instagram-link" style="display: inline-block;" target="_blank" class="instagram">
																<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/instagram.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
															</a>
															<a href="#linkdin-link" style="display: inline-block;" target="_blank" class="linkdin">
																<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/linkdin.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
															</a>
														</td>
													</tr>


													<tr>
														<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
									<tr>
										<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>';

            $mail->send();
            // echo "Mail sended :v";
            return true;
        }
        catch(Exception $e){
            echo $e->errorMessage();
            return false;
        }
    }


	public function sedMailCita3(Subscribe $subs){

        $mail = new PHPMailer(true);

        try{

            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $this->smtp;                            //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $this->emailSender;                     //SMTP username
            $mail->Password   = $this->passSender;                      //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = $this->port;                            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($this->emailSender, 'G.R.A.C');
            $mail->addAddress($this->email, $this->nombre);     //Add a recipient
            $mail->addReplyTo('info@example.com', 'Cita generada');

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Hola Te saluda el Dr. Jose Adames ' ;

            $mail->Body = '
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#f9f9f9" id="bodyTable">
				<tbody>
					<tr>
						<td style="padding-right:10px;padding-left:10px;" align="center" valign="top" id="bodyCell">

							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperBody" style="max-width:600px">
								<tbody>
									<tr>
										<td align="center" valign="top">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableCard" style="background-color:#fff;border-color:#e5e5e5;border-style:solid;border-width:0 1px 1px 1px;">
												<tbody>
													<tr>
														<td style="background-color:#00d2f4;font-size:1px;line-height:3px" class="topBorder" height="3">&nbsp;</td>
													</tr>
													<tr>
														<td style="padding-top: 60px; padding-bottom: 20px;" align="center" valign="middle" class="emailLogo">
															<h2>CORSANO</h2>
														</td>
													</tr>

													<tr>
														<td style="padding-bottom: 15px;" align="center" valign="top" class="imgHero">

															<a href="https://ibb.co/yV47j29"><img src="https://i.ibb.co/stWzY7f/Captura.jpg" alt="Captura" border="0"></a>
														</td>
													</tr>
													<tr>
														<td style="padding-bottom: 5px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="mainTitle">
															<h2 class="text" style="color:#000;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:28px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:36px;text-transform:none;text-align:center;padding:0;margin:0">
															Hola "'. $this->nombre.'"
															</h2>
														</td>
													</tr>
													<tr>
														<td style="padding-bottom: 30px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="subTitle">
															<h4 class="text" style="color:#999;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:24px;text-transform:none;text-align:center;padding:0;margin:0">
															Tengo un mensaje tuyo </h4>
														</td>
													</tr>
													<tr>
														<td style="padding-left:20px;padding-right:20px" align="center" valign="top" class="containtTable ui-sortable">
															<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription" style="">
																<tbody>
																	<tr>
																		<td style="padding-bottom: 20px;" align="center" valign="top" class="description">
																			<p class="text" style="color:#666;font-family:"Open Sans",Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:22px;text-transform:none;text-align:center;padding:0;margin:0">
																			Estimado Paciente <b>'.$this->nombre.'</b>, en base a tu motivo  <b>'. $subs->motivo.'</b> con el siguiente mensaje <b>'. $subs->mensaje .' </b>.
																			</p>
 
																			<p></p>
																			<p class="text" style="color:#666;font-family:"Open Sans",Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:22px;text-transform:none;text-align:center;padding:0;margin:0">
																			 Te sugiero lo siguiente:
																				. <b>'. $subs->observacion. ' 
																			</p>




																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td style="font-size:1px;line-height:1px" height="20">&nbsp;</td>
													</tr>
												</tbody>
											</table>
											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
												<tbody>
													<tr>
														<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperFooter" style="max-width:600px">
								<tbody>
									<tr>
										<td align="center" valign="top">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
												<tbody>
													<tr>
														<td style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px" align="center" valign="top" class="socialLinks">
															<a href="#facebook-link" style="display:inline-block" target="_blank" class="facebook">
																<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/facebook.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
															</a>
															<a href="#twitter-link" style="display: inline-block;" target="_blank" class="twitter">
																<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/twitter.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
															</a>
															<a href="#pintrest-link" style="display: inline-block;" target="_blank" class="pintrest">
																<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/pintrest.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
															</a>
															<a href="#instagram-link" style="display: inline-block;" target="_blank" class="instagram">
																<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/instagram.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
															</a>
															<a href="#linkdin-link" style="display: inline-block;" target="_blank" class="linkdin">
																<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/linkdin.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
															</a>
														</td>
													</tr>


													<tr>
														<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
									<tr>
										<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>';

            $mail->send();
            // echo "Mail sended :v";
            return true;
        }
        catch(Exception $e){
            echo $e->errorMessage();
            return false;
        }
    }
}
