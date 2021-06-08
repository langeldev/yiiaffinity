<?php

namespace app\components;

use Aws\S3\S3Client;
use Yii;

class Utilidad
{

    /**
     * Inicia el cliente de AWS
     * @return \Aws\S3\S3Client
     */
    private static function inicializar()
    {
        $s3Cliente = new S3Client([
            'version' => 'latest',
            'region' => 'eu-west-3',
            'credentials' => [
                'key' => \getenv('AWSAccessKeyId'),
                'secret' =>  \getenv('AWSSecretKey')
            ],
            
        ]);
        return $s3Cliente;
    }

    /**
     * Sube el fichero a AWS S3
     * @param file $archivo
     * @param string $titulo
     * @param mixed $rutaCartel
     *
     * @return string $titulo
     */
    public static function subirCartelS3($archivo, $titulo, $rutaCartel)
    {
        $s3Cliente = static::inicializar();
        $titulo .=  Yii::$app->security->generateRandomString() . '.' . $archivo->extension;

        $s3Cliente->putObject([
            'Bucket' => 'yiiaffinity',
            'Key' =>    $titulo,
            'SourceFile' => $rutaCartel,
            'ACL' => 'public-read'
        ]);
        
        \unlink($rutaCartel);
        return $titulo;
    }
    
    /**
     * Devuelve la url del fichero almacenado en el bucket
     * @param string $cartel
     * @return string $imagen
     */
    public static function getCartel($cartel)
    {
        $s3Cliente = static::inicializar();
        return $s3Cliente->getObjectUrl('yiiaffinity', $cartel);
    }

    /**
     * Borra el fichero alojado en el bucket de aws
     * @param string $cartel
     */
    public static function borrarEnS3($cartel)
    {
        $s3Cliente = static::inicializar();
        return $s3Cliente->deleteObject([
            'Bucket' => 'yiiaffinity',
            'Key' => $cartel
        ]);
    }
}
