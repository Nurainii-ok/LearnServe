<!DOCTYPE html>
<html>
<head>
    <title>Profil Member</title>
</head>
<body>
    <h2>Profil Saya</h2>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <label>Nama:</label><br>
        <input type="text" name="name" value="{{ $user->name }}" required><br><br>

        <label>Email:</label><br>
        <input type="email" value="{{ $user->email }}" disabled><br><br>

        <label>Password (opsional):</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
