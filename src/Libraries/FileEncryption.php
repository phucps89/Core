<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/24/2017
 * Time: 10:35 AM
 */

namespace Sel2b\Core\Libraries;


class FileEncryption
{
    const FILE_ENCRYPTION_BLOCKS = 10000;
    const FILE_ENCRYPTION_SIGN = 'encrypted';

    private static function getSignature(){
        return sha1(self::FILE_ENCRYPTION_SIGN);
    }

    public static function encryptFile($source, $dest)
    {
        $key = random_bytes(16);
        $key = substr(sha1($key, true), 0, 16);
        $iv = openssl_random_pseudo_bytes(16);

        $error = false;
        if ($fpOut = fopen($dest, 'w')) {
            // Put the initialzation vector to the beginning of the file
            fwrite($fpOut, self::getSignature());
            fwrite($fpOut, $iv);
            if ($fpIn = fopen($source, 'rb')) {
                fwrite($fpOut, $key);
                while (!feof($fpIn)) {
                    $plaintext = fread($fpIn, 16 * self::FILE_ENCRYPTION_BLOCKS);
                    $ciphertext = openssl_encrypt($plaintext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                    // Use the first 16 bytes of the ciphertext as the next initialization vector
                    $iv = substr($ciphertext, 0, 16);
                    fwrite($fpOut, $ciphertext);
                }
                fclose($fpIn);
            } else {
                $error = true;
            }
            fclose($fpOut);
        } else {
            $error = true;
        }

        return $error ? false : $dest;
    }

    public static function decryptFile($source, $dest)
    {
        //$key = substr(sha1($key, true), 0, 16);

        $error = false;
        if ($fpOut = fopen($dest, 'w')) {
            if ($fpIn = fopen($source, 'rb')) {
                // Get the initialzation vector from the beginning of the file
                $signature = fread($fpIn, 40);
                if(strcmp($signature, self::getSignature()) == 0){
                    $iv = fread($fpIn, 16);
                    $key = fread($fpIn, 16);
                    while (!feof($fpIn)) {
                        // we have to read one block more for decrypting than for encrypting
                        $ciphertext = fread($fpIn, 16 * (self::FILE_ENCRYPTION_BLOCKS + 1));
                        $plaintext = openssl_decrypt($ciphertext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                        // Use the first 16 bytes of the ciphertext as the next initialization vector
                        $iv = substr($ciphertext, 0, 16);
                        fwrite($fpOut, $plaintext);
                    }
                    fclose($fpIn);
                    fclose($fpOut);
                }
                else{
                    fclose($fpIn);
                    fclose($fpOut);
                    copy($source, $dest);
                }
            } else {
                $error = true;
            }
        } else {
            $error = true;
        }

        return $error ? false : $dest;
    }

    public static function encryptString($content){
        $key = uniqid();
        $srcFile = storage_path('encrypt/').$key.'.src';
        $desFile = storage_path('encrypt/').$key.'.des';
        Helpers::makePath($srcFile);
        file_put_contents($srcFile, $content);
        self::encryptFile($srcFile, $desFile);
        $contentEncrypt = file_get_contents($desFile);
        unlink($srcFile);
        unlink($desFile);
        return base64_encode($contentEncrypt);
    }

    public static function decryptString($contentEncrypt){
        $contentEncrypt = base64_decode($contentEncrypt);
        $key = uniqid();
        $srcFile = storage_path('decrypt/').$key.'.src';
        $desFile = storage_path('decrypt/').$key.'.des';
        Helpers::makePath($srcFile);
        file_put_contents($srcFile, $contentEncrypt);
        self::decryptFile($srcFile, $desFile);
        $content = file_get_contents($desFile);
        unlink($srcFile);
        unlink($desFile);
        return $content;
    }
}