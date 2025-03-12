<?php

namespace Alpha1130\OpenAdminTinymce;

use QCloud\COSSTS\Sts;

class OpenAdminTinymceHelper
{
    public static function buildQCSTempKeys($config)
    {
        $sts = new Sts();

        // 获取临时密钥，计算签名
        $tempKeys = $sts->getTempKeys([
            'url' => 'https://sts.tencentcloudapi.com/', // url和domain保持一致
            'domain' => 'sts.tencentcloudapi.com', // 域名，非必须，默认为 sts.tencentcloudapi.com
            'proxy' => '',
            'secretId' => $config['secret_id'], // 固定密钥,若为明文密钥，请直接以'xxx'形式填入，不要填写到getenv()函数中
            'secretKey' => $config['secret_key'], // 固定密钥,若为明文密钥，请直接以'xxx'形式填入，不要填写到getenv()函数中
            'bucket' => $config['bucket'], // 换成你的 bucket
            'region' => $config['region'], // 换成 bucket 所在园区
            'durationSeconds' => 1800, // 密钥有效期
            'allowPrefix' => ['*'], // 这里改成允许的路径前缀，可以根据自己网站的用户登录态判断允许上传的具体路径，例子： a.jpg 或者 a/* 或者 * (使用通配符*存在重大安全风险, 请谨慎评估使用)
            // 密钥的权限列表。简单上传和分片需要以下的权限，其他权限列表请看 https://cloud.tencent.com/document/product/436/31923
            'allowActions' => [
                // 简单上传
                'name/cos:PutObject',
                'name/cos:PostObject',
                // 分片上传
                'name/cos:InitiateMultipartUpload',
                'name/cos:ListMultipartUploads',
                'name/cos:ListParts',
                'name/cos:UploadPart',
                'name/cos:CompleteMultipartUpload'
            ],
            // 临时密钥生效条件，关于condition的详细设置规则和COS支持的condition类型可以参考 https://cloud.tencent.com/document/product/436/71306
            "condition" => [
                // "ip_equal" => array(
                //     "qcs:ip" => array(
                //         "10.217.182.3/24",
                //         "111.21.33.72/24",
                //     )
                // )
            ]
        ]);

        $tempKeys['bucket'] = $config['bucket'];
        $tempKeys['region'] = $config['region'];
        $tempKeys['keyPrefix'] = $config['key_prefix'];

        return $tempKeys;
    }
}