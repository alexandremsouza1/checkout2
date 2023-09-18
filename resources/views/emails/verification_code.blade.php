
<!DOCTYPE html>
  <html>
  <head>
      <meta charset="utf-8">
      <title></title>
  </head>
  <body>
  <div style="max-width: 640px; background-color: #F7F7F7; margin: 0 auto; text-align: center; padding: 20px 0 20px;">
      <!-- <div style="max-width: 640px;"> -->
      <img style="width: 100%; max-width: 297px;" src="/images/logococaEmail.png">

      <h4 style="color: #525252; font-size: 36px; font-family: SANS-SERIF; font-weight: 500; margin-top: 10px;">Código de Ativação</h4>


      <hr style="border: 3px solid #d10011; margin-bottom: 40px;">

      <p style="font-family: SANS-SERIF; font-size: 14px;">Olá <b>{{ $info['name'] }}</b></p>

      <p style="font-family: SANS-SERIF; font-size: 14px;">Segue o código de ativação de acesso ao app</p>

      <div style="max-width: 300px; padding: 20px 30px; background-color: #ffffff; margin: 40px auto 30px;">

            <div style="width: 100%; display: grid; padding: 10px; margin: 0 auto; text-align: center;">
              <div style="border:#1c2128 2px solid;font-size:28px; padding:15px 15px;">
                  {{ $info['name'] }}
              </div>
              <div style="border:#1c2128 2px solid;font-size:28px; padding:15px 15px;">
                  {{ $info['verificationCode'] }}
              </div>
          </div>

      </div>

      <img style="width: 100%; max-width: 98px;" src="/images/LogoSR.png">

      <p style="font-size: 9px; font-weight: 600; color: #707070;">Central de Atendimento Sorocaba Refrescos: Atendimento 24 horas por dia, 7 dias por semana.</p>

  </div>
  </body>
</html>