@extends('adminlte.layouts.app2')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1 class="mb-3 text-success">
                <i class="fas fa-user-cog"></i> Kelola Akun
            </h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Informasi Akun -->
                <div class="col-md-5">
                    <div class="card card-success shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-id-card"></i> Informasi Akun</h3>
                        </div>
                        <div class="card-body">
                            <p><strong><i class="fas fa-user"></i> Nama:</strong> {{ $nasabah->nama ?? '-' }}</p>
                            <p><strong><i class="fas fa-map-marker-alt"></i> Alamat:</strong> {{ $nasabah->alamat ?? '-' }}</p>
                            <p><strong><i class="fas fa-envelope"></i> Email:</strong> {{ $nasabah->user->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Ganti Password -->
                <div class="col-md-7">
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-key"></i> Ganti Password</h3>
                        </div>
                        <div class="card-body">
                            <form id="form-password" method="POST" action="{{ route('nasabah.updatePassword') }}">
                                @csrf
                                <div class="form-group">
                                    <label><i class="fas fa-lock"></i> Password Lama</label>
                                    <input type="password" name="password_lama" id="password_lama" class="form-control" required>
                                    <small id="password_lama_feedback" class="form-text"></small>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-unlock-alt"></i> Password Baru</label>
                                    <input type="password" id="password_baru" name="password_baru" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-check-double"></i> Konfirmasi Password Baru</label>
                                    <input type="password" id="password_baru_confirmation" name="password_baru_confirmation" class="form-control" required>
                                    <small id="password-match" class="form-text"></small>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-sync-alt"></i> Update Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('password_lama').addEventListener('keyup', function() {
    let password = this.value;
    let feedback = document.getElementById('password_lama_feedback');

    if (password.length > 0) {
        fetch("{{ route('nasabah.checkPassword') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ password_lama: password })
        })
        .then(res => res.json())
        .then(data => {
            if (data.match) {
                feedback.textContent = "✔ Password cocok";
                feedback.classList.remove("text-danger");
                feedback.classList.add("text-success");
            } else {
                feedback.textContent = "❌ Password tidak cocok";
                feedback.classList.remove("text-success");
                feedback.classList.add("text-danger");
            }
        });
    } else {
        feedback.textContent = "";
    }
});
    // SweetAlert untuk notifikasi dari controller
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#28a745'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc3545'
        });
    @endif

    // Validasi sebelum submit
    document.getElementById('form-password').addEventListener('submit', function(e) {
        let oldPass = document.getElementById('password_lama').value.trim();
        let newPass = document.getElementById('password_baru').value.trim();
        let confirmPass = document.getElementById('password_baru_confirmation').value.trim();

        if (!oldPass) {
            e.preventDefault();
            Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Password lama tidak boleh kosong!' });
            return;
        }

        if (newPass.length < 6) {
            e.preventDefault();
            Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Password baru minimal 6 karakter!' });
            return;
        }

        if (newPass !== confirmPass) {
            e.preventDefault();
            Swal.fire({ icon: 'error', title: 'Password Tidak Cocok!', text: 'Password baru dan konfirmasi tidak sama.' });
            return;
        }
    });

    // Validasi realtime password baru & konfirmasi
    const newPassInput = document.getElementById('password_baru');
    const confirmPassInput = document.getElementById('password_baru_confirmation');
    const matchText = document.getElementById('password-match');

    function checkPasswordMatch() {
        if (confirmPassInput.value.length === 0) {
            matchText.textContent = '';
            return;
        }
        if (newPassInput.value === confirmPassInput.value) {
            matchText.textContent = 'Password cocok ✅';
            matchText.style.color = 'green';
        } else {
            matchText.textContent = 'Password tidak cocok ❌';
            matchText.style.color = 'red';
        }
    }

    newPassInput.addEventListener('keyup', checkPasswordMatch);
    confirmPassInput.addEventListener('keyup', checkPasswordMatch);
</script>
@endsection
