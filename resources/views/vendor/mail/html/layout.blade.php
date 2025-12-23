<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{{ config('app.name') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
@media only screen and (max-width: 600px) {
.inner-body {
width: 100% !important;
}

.footer {
width: 100% !important;
}

/* 1. Background lebih lembut */
.body {
    background-color: #f3f4f6;
    color: #374151;
}

/* 2. Tombol Utama (Ubah jadi HITAM) */
.button-primary {
    background-color: #111111;
    border-bottom: 8px solid #111111;
    border-left: 18px solid #111111;
    border-right: 18px solid #111111;
    border-top: 8px solid #111111;
    border-radius: 8px; /* Sudut tumpul modern */
}

/* 3. Header (Logo Area) */
.header {
    padding: 25px 0;
    text-align: center;
}
.header a {
    color: #111111;
    font-size: 24px;
    font-weight: bold;
    text-decoration: none;
    text-transform: uppercase;
}

/* 4. Panel (Kotak Info Order) */
.panel-item {
    background-color: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 15px;
}

/* 5. Custom Class untuk Total Harga (Merah) */
/* Tambahkan ini di paling bawah file */
.text-red {
    color: #EF4444 !important;
}
.text-total {
    font-size: 18px;
    font-weight: bold;
}
.table th {
    color: #9ca3af;
    font-size: 12px;
    text-transform: uppercase;
}
}

@media only screen and (max-width: 500px) {
.button {
width: 100% !important;
}
}
</style>
{!! $head ?? '' !!}
</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
{!! $header ?? '' !!}

<!-- Email Body -->
<tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<!-- Body content -->
<tr>
<td class="content-cell">
{!! Illuminate\Mail\Markdown::parse($slot) !!}

{!! $subcopy ?? '' !!}
</td>
</tr>
</table>
</td>
</tr>

{!! $footer ?? '' !!}
</table>
</td>
</tr>
</table>
</body>
</html>
