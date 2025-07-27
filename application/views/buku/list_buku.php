<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Buku Digital</title>
    <!-- Memuat Tailwind CSS dari CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Memuat font Inter dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Gaya dasar untuk body, menggunakan font Inter dan warna latar belakang */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        /* Gaya untuk container utama, membatasi lebar dan memusatkan */
        .container {
            max-width: 1000px;
        }
        /* Styling untuk pagination links */
        .pagination span {
            display: inline-block;
            margin: 0 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .pagination a {
            display: inline-block;
            margin: 0 4px;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body class="p-4">
    <div class="container mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Perpustakaan Buku Digital</h1>

        <!-- Search Bar Section -->
        <form action="<?php echo site_url('buku/index'); ?>" method="get" class="mb-6 flex items-center gap-4">
            <input type="text" name="search" placeholder="Cari berdasarkan judul atau penulis..." class="flex-grow shadow appearance-none border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($this->input->get('search')); ?>">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                Cari
            </button>
            <?php if ($this->input->get('search')): ?>
                <a href="<?php echo site_url('buku'); ?>" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                    Reset
                </a>
            <?php endif; ?>
        </form>

        <!-- Tombol Tambah Buku Baru dan Logout -->
        <div class="flex justify-between items-center mb-6">
            <a href="<?php echo site_url('buku/add'); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out inline-block">
                Tambah Buku Baru
            </a>
            <a href="<?php echo site_url('auth/logout'); ?>" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out inline-block">
                Logout
            </a>
        </div>

        <!-- Tabel Daftar Buku -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun Terbit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody id="bookList" class="divide-y divide-gray-200">
                    <?php
                    if (!empty($buku)) {
                        foreach ($buku as $item) {
                    ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($item->judul); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($item->penulis); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($item->tahun_terbit); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($item->isbn); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="<?php echo site_url('buku/edit/' . $item->id); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded-md mr-2 transition duration-300 ease-in-out">Edit</a>
                                    <a href="<?php echo site_url('buku/delete/' . $item->id); ?>" class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded-md transition duration-300 ease-in-out" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">Hapus</a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada buku ditemukan.</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-6">
            <?php
            // Periksa apakah $pagination_links didefinisikan sebelum menampilkannya
            if (isset($pagination_links)) {
                echo $pagination_links;
            }
            ?>
        </div>

    </div>
</body>
</html>
