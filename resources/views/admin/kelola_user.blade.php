<x-layout>
    <div class="pagetitle" style="display: flex; justify-content: center; align-items: center;">
        <h1 style="font-size: 2.5rem;">Kelola User</h1>
    </div><!-- End Page Title -->



    <div class="d-flex justify-content-end mb-3">
        <a href="/admin/kelola_user/add">
            <button type="button" class="btn btn-primary my-2 btn-icon-text">
                <i class="ri-add-fill"></i> Tambah
            </button>
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">


                        <!-- Default Table -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Id Pegawai</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Terdaftar</th>
                                    <th scope="col">Level Akses</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">PM201605</th>
                                    <td>Brandon Jacob</td>
                                    <td>Programmer</td>
                                    <td>brandon@example.com</td>
                                    <td>2016-05-25</td>
                                    <td>User</td>
                                    <td>
                                        <form action="/admin/kelola_user/delete/1" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="ri-delete-bin-5-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">SE201412</th>
                                    <td>Bridie Kessler</td>
                                    <td>Sofware Engineer</td>
                                    <td>bridie@example.com</td>
                                    <td>2014-12-05</td>
                                    <td>User</td>
                                    <td>
                                        <form action="/admin/kelola_user/delete/2" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="ri-delete-bin-5-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">QA201108</th>
                                    <td>Ashleigh Langosh</td>
                                    <td>Quality Assurance</td>
                                    <td>ashleigh@example.com</td>
                                    <td>2011-08-12</td>
                                    <td>User</td>
                                    <td>
                                        <form action="/admin/kelola_user/delete/3" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="ri-delete-bin-5-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">SA201206</th>
                                    <td>Angus Grady</td>
                                    <td>System Analyst</td>
                                    <td>angus@example.com</td>
                                    <td>2012-06-11</td>
                                    <td>User</td>
                                    <td>
                                        <form action="/admin/kelola_user/delete/4" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="ri-delete-bin-5-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">NE201104</th>
                                    <td>Raheem Lehner</td>
                                    <td>Network Engineer</td>
                                    <td>raheem@example.com</td>
                                    <td>2011-04-19</td>
                                    <td>User</td>
                                    <td>
                                        <form action="/admin/kelola_user/delete/5" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="ri-delete-bin-5-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- End Default Table Example -->
                    </div>
                </div>

            </div>

            <div class="col-lg-6">
                <!-- Additional content can go here -->
            </div>
        </div>
    </section>
</x-layout>