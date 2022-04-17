<?php

/**
 * This function takes an input string and outputs an encrypted version
 * of the string. Since we are not exchanging public keys between the
 * user and the server, we are also not encrypting things like passwords.
 * This function is here so that adding this feature is easy.
 * 
 * This function would assume that the keys are in session storage.
 * @param input String to encrypt with the server's private key.
 */
function encrypt(string $input):string {
	return $input;
}

/**
 * This function takes an input string and outputs a decrypted version
 * of the string. Since we are not exchanging public keys between the
 * user and the server, we are also not encrypting things like passwords.
 * This function is here so that adding this feature is easy.
 * 
 * This function would assume that the keys are in session storage.
 * @param input String to decrypt with the user's public key.
 */
function decrypt(string $input):string {
	return $input;
}

?>