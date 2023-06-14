<!doctype html>
<html lang="en">
<head>
  <title>Aplikacja bankowa - technologie internetowe</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <div class="section">
    <div class="container">
      <div class="row full-height justify-content-center">
        <div class="col-12 text-center align-self-center py-5">
          <div class="section pb-5 pt-5 pt-sm-2 text-center">
            <h6 class="mb-0 pb-3"><span>Zaloguj się</span><span>Zarejestruj się</span></h6>
            <input class="checkbox" type="checkbox" id="reg-log" name="reg-log" />
            <label for="reg-log"></label>
            <div class="card-3d-wrap mx-auto">
              <div class="card-3d-wrapper">
                <div class="card-front">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <form action="login.php" method="post">
                      <h4 class="mb-4 pb-3" id="tytul">Zaloguj się
                      </h4>
                      <div class="form-group">
                        <input type="text" class="form-style" name="email" id="email" placeholder="Email" required>
                        <i class="input-icon uil uil-at"></i>
                      </div>
                      <div class="form-group mt-2">
                        <input type="password" class="form-style" name="password" id="password" placeholder="Hasło" required>
                        <i class="input-icon uil uil-lock-alt"></i>
                      </div>
                      <!-- <input type="submit" value="Login"> -->
                      <button type="submit" class="btn mt-4" name="send">Zaloguj</button>
                    </form>
                    </div>
                  </div>
                </div>
                <div class="card-back">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <form action="register.php" method="post">
                        <h4 class="mb-3 pb-3" id="tytul">Zarejestruj się</h4>
                        <div class="form-group">
                          <input type="text" class="form-style" placeholder="Imie i nazwisko" name="name" required>
                          <i class="input-icon uil uil-user"></i>
                        </div>
                        <div class="form-group mt-2">
                          <input type="tel" class="form-style" placeholder="Numer telefonu" name="phone" required>
                          <i class="input-icon uil uil-phone"></i>
                        </div>
                        <div class="form-group mt-2">
                          <input type="email" class="form-style" placeholder="Email" name="email">
                          <i class="input-icon uil uil-at"></i>
                        </div>
                        <div class="form-group mt-2">
                          <input type="password" class="form-style" placeholder="Hasło" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                          title="Hasło musi zawierać conajmniej jedną cyfrę, jedną WIELKĄ literę i conajmniej 8 znaków" required>
                          <i class="input-icon uil uil-lock-alt"></i>
                        </div>
                        <button type="submit" class="btn mt-4" name="send">Zarejestruj</button>
                      </form>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
        <img src="/images/Money Transfer (HD).png" id="bck-img-1">
        <img src="/images/Piggy Bank (HD).png" id="bck-img-2">
      </div>
    </div>
  </div>
</body>
</html>
