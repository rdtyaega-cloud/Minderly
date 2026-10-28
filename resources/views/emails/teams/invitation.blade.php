<div style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6; max-width: 560px; margin: 0 auto; padding: 32px 20px;">
    <p style="margin: 0 0 8px; color: #064b87; font-size: 13px; font-weight: 700;">MINDERLY · KOLABORASI TIM</p>
    <h1 style="margin: 0 0 16px; font-size: 24px;">Kamu diundang bergabung</h1>
    <p><strong>{{ $inviter->nama }}</strong> mengundangmu bergabung ke tim <strong>{{ $team->name }}</strong>.</p>
    @if ($team->description)
        <p style="color: #4b5563;">{{ $team->description }}</p>
    @endif
    <p style="margin: 28px 0;">
        <a href="{{ $inviteUrl }}" style="display: inline-block; border-radius: 8px; background: #064b87; padding: 12px 20px; color: #fff; font-weight: 700; text-decoration: none;">Bergabung ke tim</a>
    </p>
    <p style="color: #6b7280; font-size: 13px;">Tautan ini berlaku selama 7 hari dan hanya dapat digunakan oleh akun dengan alamat email yang menerima undangan.</p>
    <p style="color: #6b7280; font-size: 12px; word-break: break-all;">Jika tombol tidak berfungsi, buka: {{ $inviteUrl }}</p>
</div>