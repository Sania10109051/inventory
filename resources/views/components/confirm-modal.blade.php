<div>
    <script>
        function confirmModal(e){
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Andaa Yakin?',
                text: "Tindakan tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            })
        }
    </script>
</div>