<?php

namespace App\Helpers;

class ContactHelper
{
    /**
     * Format phone number for WhatsApp wa.me link.
     * Converts +62 812-3456-7890 to 6281234567890
     */
    public static function whatsappUrl(?string $phone, string $message = ''): ?string
    {
        if (empty($phone)) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $phone);
        if (empty($digits)) {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (!str_starts_with($digits, '62')) {
            $digits = '62' . $digits;
        }

        $url = 'https://wa.me/' . $digits;
        if (!empty($message)) {
            $url .= '?text=' . rawurlencode($message);
        }
        return $url;
    }
}
