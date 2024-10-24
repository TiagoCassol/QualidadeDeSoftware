<?php
$server = "localhost";
$userDb = "root";
$passDb = "12345";
$nameDb = "petshop";
$port = 3306;

$connect = mysqli_connect($server, $userDb, $passDb, $nameDb, $port);

if (!$connect) {
    die("Falha na conexão: " . mysqli_connect_error());
}

function login($connect)
{
    if (isset($_POST['signin'])) {
        $check_email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if ($check_email === false) {
            echo '<label style="color: red; font-size: 2rem;">E-mail inválido!</label>';
            return;
        }
        $email = mysqli_real_escape_string($connect, $check_email);
        $password = mysqli_real_escape_string($connect, $_POST['password']);

        if (!empty($email) && !empty($password)) {
            $query = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
            $executar = mysqli_query($connect, $query);

            if (!$executar) {
                // Erro ao executar a consulta
                echo '<label style="color: red; font-size: 2rem;">Erro ao executar a consulta: ' . mysqli_error($connect) . '</label>';
                return;
            }

            $verifica = mysqli_num_rows($executar);
            $usuario = mysqli_fetch_assoc($executar);

            if ($verifica > 0) {

                // Inicia uma sessão (login)
                session_start();
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['name'] = $usuario['name'];
                $_SESSION['password'] = $usuario['password'];
                $_SESSION['ativa'] = true;
                header("location: shop.php"); // Redireciona para a página de administração
                exit;
            } else {
                echo '<label style="color: red; font-size: 2rem;">E-mail ou senha não encontrados!</label>';
            }
        } else {
            echo '<label style="color: red; font-size: 2rem;">E-mail ou senha incorretos!</label>';
        }
    }
}


function logout()
{
	session_start();
	session_unset();
	session_destroy();
	header("location: index.html"); // Redireciona para a página inicial
}

function sign_up($connect)
{
	if (isset($_POST['signup']) and !empty($_POST['email']) and !empty($_POST['password'])) {
		$erros = array();
		$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
		$nome = mysqli_real_escape_string($connect, $_POST['name']);
		$senha = ($_POST['password']);


		$queryEmail = "SELECT email FROM usuarios WHERE email = '$email' ";
		$buscaEmail = mysqli_query($connect, $queryEmail);
		$verifica = mysqli_num_rows($buscaEmail); # traz número de linhas
		if (!empty($verifica)) {
			$erros[] = "E-mail já cadastrado!";
		}

    if (strlen($senha) < 8) {
        $erros[] = "Tamanho da senha deve ser de no mínimo 8 caracteres";
    }
			
		

		if (empty($erros)) {
			$query = "INSERT INTO usuarios (name,email,password) 
			values ('$nome','$email','$senha')";
            $result = mysqli_query($connect, $query);
			echo "<script>
                    alert('cadastrado realizado com sucesso.');
                    window.location.href = 'login.php';
                </script>";
		} else {
			foreach ($erros as $erro) {
				echo "<p>$erro</p>";
			}
		}
	}
}

function loginTeste($connect, $email, $password)
{
    $check_email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if ($check_email === false) {
        return 'E-mail inválido!';
    }

    $email = mysqli_real_escape_string($connect, $check_email);
    $password = mysqli_real_escape_string($connect, $password);

    if (!empty($email) && !empty($password)) {
        $query = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
        $executar = mysqli_query($connect, $query);

        if (!$executar) {
            return 'Erro ao executar a consulta: ' . mysqli_error($connect);
        }

        $verifica = mysqli_num_rows($executar);
        $usuario = mysqli_fetch_assoc($executar);

        if ($verifica > 0) {
            // Simulando o início da sessão
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['name'] = $usuario['name'];
            $_SESSION['password'] = $usuario['password'];
            $_SESSION['ativa'] = true;
            return 'login_success';
        } else {
            return 'E-mail ou senha não encontrados!';
        }
    } else {
        return 'E-mail ou senha incorretos!';
    }
}

// class LoginTest extends TestCase
// {
//     public function testLoginWithValidCredentials()
//     {
//         // Mock da conexão com o banco de dados
//         $mockConnect = $this->createMock(mysqli::class);

//         // Simulando a resposta de mysqli_query
//         $mockResult = $this->createMock(mysqli_result::class);
//         $mockConnect->method('query')->willReturn($mockResult);

//         // Simulando que 1 linha foi retornada (usuário encontrado)
//         $mockResult->method('num_rows')->willReturn(1);
//         $mockResult->method('fetch_assoc')->willReturn([
//             'email' => 'user@example.com',
//             'name' => 'Test User',
//             'password' => 'password'
//         ]);

//         // Chamada à função de login
//         $result = loginTeste($mockConnect, 'user@example.com', 'password');

//         // Verificando o resultado esperado
//         $this->assertEquals('login_success', $result);
//         $this->assertEquals('user@example.com', $_SESSION['email']);
//         $this->assertEquals('Test User', $_SESSION['name']);
//         $this->assertTrue($_SESSION['ativa']);
//     }

//     public function testLoginWithInvalidEmail()
//     {
//         // Mock da conexão com o banco de dados
//         $mockConnect = $this->createMock(mysqli::class);

//         // Testando um e-mail inválido
//         $result = loginTeste($mockConnect, 'invalid-email', 'password');
        
//         // Verificando se o erro de e-mail inválido é retornado
//         $this->assertEquals('E-mail inválido!', $result);
//     }

//     // Outros testes poderiam ser feitos para testar:
//     // - Quando as credenciais estão incorretas (nenhuma linha retornada)
//     // - Quando há erro de execução da query
// }



// class MathTest extends TestCase {
//     public function testAddition() {
//         $this->assertEquals(4, 2 + 2);
//     }
// }


