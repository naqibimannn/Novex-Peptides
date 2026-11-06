@extends('frontend.home.index')

@section('seo')
<x-seo 
    title="Privacy Policy / Dasar Privasi | Novex Peptides"
    description="Privacy Policy and Dasar Privasi for Novex Peptides. Learn how we handle technical logs, Google Analytics 4, cookies, and direct communication."
    :canonical="url('/privacy-policy')"
/>
@endsection

@section('content')
<section class="sec" style="padding: 72px 0 96px; color: var(--text-main, #0F172A); line-height: 1.8;">
  <div class="wrap" style="max-width: 860px; margin: 0 auto; padding: 0 24px;">
    
    <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 40px; padding-bottom: 28px; border-bottom: 1px solid #E2E8F0;">
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; color: var(--brand, #0071E3);">
          Official Documentation
        </span>

        <div style="display: inline-flex; align-items: center; background: #F1F5F9; padding: 4px; border-radius: 9999px; border: 1px solid #E2E8F0;">
          <button type="button" id="btnLangEn" onclick="switchPrivacyLang('en')" style="padding: 6px 16px; border-radius: 9999px; font-size: 12px; font-weight: 700; border: none; cursor: pointer; transition: all 0.2s; background: #0071E3; color: #FFFFFF; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            English
          </button>
          <button type="button" id="btnLangBm" onclick="switchPrivacyLang('bm')" style="padding: 6px 16px; border-radius: 9999px; font-size: 12px; font-weight: 700; border: none; cursor: pointer; transition: all 0.2s; background: transparent; color: #64748B;">
            Bahasa Malaysia
          </button>
        </div>
      </div>

      <div id="headerEn">
        <h1 style="font-size: clamp(30px, 4.5vw, 44px); font-weight: 800; margin: 0 0 8px; letter-spacing: -0.02em;">Privacy Policy</h1>
        <p style="font-size: 13px; color: var(--text-muted, #5A6F82); margin: 0;">
          Last updated: November 2026 &bull; Effective: November 2026
        </p>
      </div>

      <div id="headerBm" style="display: none;">
        <h1 style="font-size: clamp(30px, 4.5vw, 44px); font-weight: 800; margin: 0 0 8px; letter-spacing: -0.02em;">Dasar Privasi</h1>
        <p style="font-size: 13px; color: var(--text-muted, #5A6F82); margin: 0;">
          Kemas kini terakhir: November 2026 &bull; Berkuat kuasa: November 2026
        </p>
      </div>
    </div>

    <div id="contentEn" style="font-size: 15px; display: flex; flex-direction: column; gap: 32px;">
      <div>
        <p>
          This Privacy Policy describes how Novex Peptides (&ldquo;we&rdquo;, &ldquo;our&rdquo;, or &ldquo;us&rdquo;) handles information when you visit our website. We respect your privacy and operate with transparency.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">1. No accounts or on-site forms</h2>
        <p>
          This website is an informational catalog. We do not require registration or sign-in, and there are no on-site forms that collect your name, address, or payment card details.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">2. Technical logs</h2>
        <p>
          Our servers record basic technical logs for security and performance: visit timestamps, requested page URLs, HTTP status codes, referring URLs, and browser and operating system type. We do not use IP addresses to identify individuals.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">3. Cookies and Google Analytics 4</h2>
        <p style="margin-bottom: 12px;">
          We use Google Analytics 4 (GA4), provided by Google LLC, to understand how visitors use our website.
        </p>
        <ul style="padding-left: 20px; list-style-type: disc; display: flex; flex-direction: column; gap: 8px;">
          <li>GA4 uses cookies to collect aggregate data such as session duration and navigation paths. Data is sent to Google servers that may be located outside Malaysia.</li>
          <li>GA4 cookies are activated only after you click &ldquo;Accept&rdquo; on the cookie consent popup. If you click &ldquo;Reject&rdquo;, GA4 will not be loaded.</li>
          <li>GA4 event data is retained for 2 months. User data linked to cookies is retained for up to 14 months, and this period restarts when the same visitor returns to the website.</li>
          <li>You can withdraw your consent at any time by clicking &ldquo;Cookie Settings&rdquo; at the bottom of the website to reopen the cookie consent popup and change your choice. You can also delete cookies through your browser settings. The website remains fully accessible without these cookies.</li>
        </ul>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">4. WhatsApp button and direct communication</h2>
        <p style="margin-bottom: 12px;">
          This website has a WhatsApp button so you can contact us. When you tap it, you leave our website and are taken to WhatsApp.
        </p>
        <ul style="padding-left: 20px; list-style-type: disc; display: flex; flex-direction: column; gap: 8px;">
          <li>Information you share through WhatsApp (for example your name, phone number, and details of your enquiry or order) is received and used only to reply to your enquiry and process your order.</li>
          <li>We keep enquiry messages for 12 months after the last message. Messages related to orders and payments are kept for up to 7 years for business and tax record purposes. We do not sell your information to others.</li>
          <li>WhatsApp is a third-party service governed by its own privacy policy and terms. We do not control how WhatsApp handles your data.</li>
        </ul>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">5. How we use data</h2>
        <p>
          Technical and analytics data is used to keep the server stable, understand which catalog sections are viewed most, and improve layout and user experience.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">6. Third-party links</h2>
        <p>
          This website may link to external platforms (for example Instagram or TikTok). Those platforms have their own privacy policies and we are not responsible for their practices.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">7. Data security</h2>
        <p>
          We apply appropriate technical safeguards, including HTTPS (SSL/TLS encryption) on all pages.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">8. Your rights</h2>
        <p>
          You may request access to the personal data we hold about you, ask for corrections, and withdraw consent. Contact us at the email below and we will respond within a reasonable time.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">9. Changes to this policy</h2>
        <p>
          We may update this policy from time to time. Changes will be posted on this page with a revised date.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">10. Contact us</h2>
        <p style="line-height: 1.8;">
          Email: <a href="mailto:support@novexsupps.com" style="color: var(--brand, #0071E3); text-decoration: underline;">support@novexsupps.com</a><br>
          Website: <a href="https://novexsupps.com" style="color: var(--brand, #0071E3); text-decoration: underline;">https://novexsupps.com</a>
        </p>
      </div>
    </div>

    <div id="contentBm" style="display: none; font-size: 15px; flex-direction: column; gap: 32px;">
      <div>
        <p>
          Dasar Privasi ini menerangkan bagaimana Novex Peptides (&ldquo;kami&rdquo;) mengendalikan maklumat apabila anda melawat laman web kami. Kami menghormati privasi anda dan beroperasi secara telus.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">1. Tiada akaun dan borang di laman web</h2>
        <p>
          Laman web ini ialah katalog maklumat. Kami tidak memerlukan anda mendaftar akaun atau log masuk, dan tiada borang di laman web yang mengumpul nama, alamat atau maklumat kad kredit anda.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">2. Log teknikal</h2>
        <p>
          Sistem pelayan kami merekod log teknikal asas untuk keselamatan dan prestasi laman web, iaitu masa lawatan, URL halaman yang dilihat, kod status HTTP, URL rujukan, serta jenis pelayar dan sistem pengendalian. Kami tidak menggunakan alamat IP untuk mengenal pasti individu.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">3. Cookie dan Google Analytics 4</h2>
        <p style="margin-bottom: 12px;">
          Kami menggunakan Google Analytics 4 (GA4) yang disediakan oleh Google LLC untuk memahami bagaimana pengunjung menggunakan laman web kami.
        </p>
        <ul style="padding-left: 20px; list-style-type: disc; display: flex; flex-direction: column; gap: 8px;">
          <li>GA4 menggunakan cookie untuk mengumpul data agregat seperti tempoh sesi dan laluan navigasi. Data dihantar ke pelayan Google yang mungkin terletak di luar Malaysia.</li>
          <li>Cookie GA4 hanya diaktifkan selepas anda klik &ldquo;Terima&rdquo; pada popup persetujuan cookie. Jika anda klik &ldquo;Tolak&rdquo;, GA4 tidak akan dimuatkan.</li>
          <li>Data peristiwa GA4 disimpan selama 2 bulan. Data pengguna yang berkaitan dengan cookie disimpan sehingga 14 bulan, dan tempoh ini dimulakan semula apabila pengunjung yang sama melawat semula laman web.</li>
          <li>Anda boleh menarik balik persetujuan pada bila-bila masa dengan klik &ldquo;Tetapan Cookie&rdquo; di bahagian bawah laman web untuk membuka semula popup persetujuan cookie dan menukar pilihan anda. Anda juga boleh memadam cookie melalui tetapan pelayar. Laman web masih boleh dilayari tanpa cookie ini.</li>
        </ul>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">4. Butang WhatsApp dan komunikasi terus</h2>
        <p style="margin-bottom: 12px;">
          Laman web ini mempunyai butang WhatsApp supaya anda boleh menghubungi kami. Apabila anda menekan butang tersebut, anda meninggalkan laman web kami dan dibawa ke WhatsApp.
        </p>
        <ul style="padding-left: 20px; list-style-type: disc; display: flex; flex-direction: column; gap: 8px;">
          <li>Maklumat yang anda kongsi melalui WhatsApp (contohnya nama, nombor telefon, dan butiran pertanyaan atau pesanan) kami terima dan gunakan hanya untuk membalas pertanyaan dan memproses pesanan anda.</li>
          <li>Kami simpan mesej pertanyaan selama 12 bulan selepas mesej terakhir. Mesej yang berkaitan pesanan dan pembayaran disimpan sehingga 7 tahun untuk tujuan rekod perniagaan dan cukai. Kami tidak menjual maklumat anda kepada pihak lain.</li>
          <li>WhatsApp ialah perkhidmatan pihak ketiga dan tertakluk kepada dasar privasi dan terma WhatsApp sendiri. Kami tidak mengawal bagaimana WhatsApp mengendalikan data anda.</li>
        </ul>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">5. Penggunaan data</h2>
        <p>
          Data teknikal dan analitik digunakan untuk memastikan kestabilan pelayan, memahami bahagian katalog yang paling banyak dilihat, dan menambah baik reka letak serta pengalaman pengguna.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">6. Pautan pihak ketiga</h2>
        <p>
          Laman web ini mungkin mengandungi pautan ke platform luar (contohnya Instagram atau TikTok). Platform tersebut mempunyai dasar privasi sendiri dan kami tidak bertanggungjawab ke atas amalan mereka.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">7. Keselamatan data</h2>
        <p>
          Kami menggunakan langkah keselamatan teknikal yang sesuai, termasuk HTTPS (penyulitan SSL/TLS) di semua halaman.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">8. Hak anda</h2>
        <p>
          Anda berhak meminta akses kepada data peribadi yang kami simpan, meminta pembetulan, dan menarik balik persetujuan. Hubungi kami melalui emel di bawah dan kami akan membalas dalam tempoh yang munasabah.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">9. Perubahan dasar</h2>
        <p>
          Kami boleh mengemas kini dasar ini dari semasa ke semasa. Perubahan akan dipaparkan di halaman ini bersama tarikh semakan baharu.
        </p>
      </div>

      <div>
        <h2 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0 0 12px;">10. Hubungi kami</h2>
        <p style="line-height: 1.8;">
          Emel: <a href="mailto:support@novexsupps.com" style="color: var(--brand, #0071E3); text-decoration: underline;">support@novexsupps.com</a><br>
          Laman web: <a href="https://novexsupps.com" style="color: var(--brand, #0071E3); text-decoration: underline;">https://novexsupps.com</a>
        </p>
      </div>
    </div>

  </div>
</section>

<script>
function switchPrivacyLang(lang) {
  const btnEn = document.getElementById('btnLangEn');
  const btnBm = document.getElementById('btnLangBm');
  const headerEn = document.getElementById('headerEn');
  const headerBm = document.getElementById('headerBm');
  const contentEn = document.getElementById('contentEn');
  const contentBm = document.getElementById('contentBm');

  if (lang === 'bm') {
    btnBm.style.background = '#0071E3';
    btnBm.style.color = '#FFFFFF';
    btnBm.style.boxShadow = '0 1px 2px rgba(0,0,0,0.05)';

    btnEn.style.background = 'transparent';
    btnEn.style.color = '#64748B';
    btnEn.style.boxShadow = 'none';

    headerEn.style.display = 'none';
    headerBm.style.display = 'block';

    contentEn.style.display = 'none';
    contentBm.style.display = 'flex';
  } else {
    btnEn.style.background = '#0071E3';
    btnEn.style.color = '#FFFFFF';
    btnEn.style.boxShadow = '0 1px 2px rgba(0,0,0,0.05)';

    btnBm.style.background = 'transparent';
    btnBm.style.color = '#64748B';
    btnBm.style.boxShadow = 'none';

    headerBm.style.display = 'none';
    headerEn.style.display = 'block';

    contentBm.style.display = 'none';
    contentEn.style.display = 'flex';
  }
}
</script>
@endsection