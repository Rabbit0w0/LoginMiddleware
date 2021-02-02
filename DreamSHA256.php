<?php
/**
 * Authme 神秘的 SHA256 算法。
 *
 * @see https://github.com/AuthMe/AuthMeReloaded/blob/master/samples/website_integration/Sha256.php
 */
class DreamSHA256
{
    public function hash($value, $salt = ''): string
    {
        return '$SHA$'.$salt.'$'.hash('sha256', hash('sha256', $value).$salt);
    }

    public function verify($password, $hash, $salt = ''): bool
    {
        // Parse AuthMe's fucking in-line salt from hash
        $salt = $this->parseHash($hash)['salt'];

        return hash_equals($hash, $this->hash($password, $salt));
    }

    protected function parseHash($hash)
    {
        $parts = explode('$', $hash);

        // Hash formatted as $SHA$salt$hash
        return [
            'hash' => $parts[3],
            'salt' => $parts[2],
        ];
    }
}
