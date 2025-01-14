<?php
session_start();
include ('../config/db.php');
include ('../config/loan_functions.php');

if (isset($_POST['loan_book'])) {
	// Recupera os dados do formulário
	$user_id = $_SESSION['user_id'];
	$book_id = $_POST['book_id'];
	$return_date = $_POST['return_date'];
	$formattedReturnDate = formatDate($return_date);
	$loan_date = date('Y-m-d'); // Data atual
	$status = 'pending'; // Status inicial do empréstimo

	// Insere o empréstimo utilizando a função
	$success = insertLoan($conexao, $user_id, $book_id, $loan_date, $return_date, $status);

	if ($success) {
		// Redireciona e exibe mensagem de sucesso
		$_SESSION['message'] = "Empréstimo realizado com sucesso! Devolução prevista para: $formattedReturnDate.";
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit();
	} else {
		$_SESSION['message'] = "Erro ao solicitar empréstimo. Tente novamente.";
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit();
	}
	
}
