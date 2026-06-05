<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $content = '<p><strong>Effective Date:</strong> June 2025</p><p>The Bitter Reality ("we", "us", or "our") is committed to protecting your privacy. This Privacy Policy explains what information we collect, how we use it, and your rights regarding that information when you use our platform at <strong>thebitterreality.com</strong>.</p><h2>1. Information We Collect</h2><p>We collect the following types of information:</p><ul><li><strong>Account Information:</strong> If you create an account, we collect your name and email address. Passwords are stored in an encrypted (hashed) format and are never readable by us.</li><li><strong>Usage Data:</strong> We track which topics and chapters you read, your reading progress, and how you interact with content on the platform. This helps us improve the experience and recommend relevant content.</li><li><strong>Bookmarks and Preferences:</strong> When you save bookmarks or choose a preferred language (English or Hindi), we store those preferences to personalize your experience.</li><li><strong>Comments:</strong> Any comments you post publicly on topics are stored and displayed on the platform. Please do not include personal or sensitive information in comments.</li><li><strong>Search Queries:</strong> We collect anonymized search queries to understand trending topics and improve our content library. Individual searches are not linked to your identity.</li><li><strong>Technical Data:</strong> Like all websites, our servers automatically collect standard technical data such as your IP address, browser type, operating system, referring URL, and pages visited. This information is used solely for security monitoring and analytics.</li></ul><h2>2. How We Use Your Information</h2><p>We use the information we collect to:</p><ul><li>Operate and improve the platform and its content.</li><li>Personalize your reading experience (bookmarks, language preferences, reading history).</li><li>Identify and fix technical issues and security vulnerabilities.</li><li>Analyze content performance to decide which topics to expand or update.</li><li>Communicate with you if you contact us directly, and respond to your inquiries.</li></ul><p>We do <strong>not</strong> use your data for advertising, behavioural profiling, or any commercial purpose beyond operating this platform.</p><h2>3. Cookies</h2><p>We use a minimal set of cookies necessary for the platform to function:</p><ul><li><strong>Session cookies:</strong> Used to keep you logged in while you browse.</li><li><strong>Preference cookies:</strong> Used to remember your chosen language (English or Hindi).</li></ul><p>We do <strong>not</strong> use third-party advertising cookies or tracking pixels. We do not run Google Ads, Facebook Pixel, or any similar tracking technology.</p><h2>4. Data Sharing and Third Parties</h2><p>We do not sell, trade, or rent your personal information to any third party. Your data may be shared only in the following limited circumstances:</p><ul><li><strong>Hosting and Infrastructure:</strong> Our website is hosted on servers managed by trusted infrastructure providers. These providers act as data processors and are contractually bound to protect your data.</li><li><strong>Legal Obligations:</strong> We may disclose information if required to do so by law or in response to a valid legal request from a court or government authority.</li></ul><h2>5. Data Retention</h2><p>We retain your account data and preferences for as long as your account remains active. If you request deletion of your account, we will remove your personal information within 30 days, except where retention is required by law.</p><p>Server logs (IP addresses and technical data) are automatically purged after 90 days.</p><h2>6. Your Rights</h2><p>Depending on your jurisdiction, you may have the right to:</p><ul><li>Access the personal data we hold about you.</li><li>Request correction of inaccurate data.</li><li>Request deletion of your account and associated data.</li><li>Withdraw consent for data processing at any time.</li></ul><p>To exercise any of these rights, please contact us at <strong>info@thebitterreality.com</strong>. We will respond within 30 days.</p><h2>7. Children\'s Privacy</h2><p>The Bitter Reality is an educational platform intended for general audiences. We do not knowingly collect personal information from children under the age of 13. If you believe a child has provided us with personal information, please contact us and we will promptly delete it.</p><h2>8. Security</h2><p>We take reasonable technical and organisational measures to protect your information from unauthorised access, alteration, or disclosure. Passwords are hashed using industry-standard algorithms and are never stored in plain text. However, no method of transmission over the internet is 100% secure, and we cannot guarantee absolute security.</p><h2>9. Changes to This Policy</h2><p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal obligations. When we do, we will update the effective date at the top of this page. We encourage you to review this policy periodically.</p><h2>10. Contact Us</h2><p>If you have any questions, concerns, or requests regarding this Privacy Policy, please reach out to us at: <strong>info@thebitterreality.com</strong></p>';

        $page = DB::table('static_pages')->where('slug', 'privacy-policy')->first();

        if ($page) {
            DB::table('static_page_translations')
                ->where('static_page_id', $page->id)
                ->where('locale', 'en')
                ->update(['content' => $content]);
        }
    }

    public function down(): void
    {
        $page = DB::table('static_pages')->where('slug', 'privacy-policy')->first();

        if ($page) {
            DB::table('static_page_translations')
                ->where('static_page_id', $page->id)
                ->where('locale', 'en')
                ->update(['content' => '<p>We respect your privacy. We collect minimal data and never sell your personal information to third parties. By using this website, you agree to the terms of this privacy policy.</p>']);
        }
    }
};
