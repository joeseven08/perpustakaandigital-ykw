<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo isset($buku) ? 'Edit Buku' : 'Tambah Buku Baru'; ?>
    </title>
    <!-- Load Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Inter font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Basic styles for the body, using Inter font and background color */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        /* Styles for the main container, limiting width and centering */
        .container {
            max-width: 600px; /* Reduced max-width for a more compact form */
        }
    </style>
</head>
<body class="p-4">
    <div class="container mx-auto bg-white p-6 rounded-xl shadow-lg">
        <!-- Dynamic title for Add/Edit form -->
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">
            <?php echo isset($buku) ? 'Edit Buku' : 'Tambah Buku Baru'; ?>
        </h1>

        <!-- Display validation errors if any -->
        <?php echo validation_errors('<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">', '</div>'); ?>

        <!-- Form for adding or editing a book -->
        <!-- Action URL changes based on whether it's an add or edit operation -->
        <?php echo form_open(isset($buku) ? 'buku/edit/' . $buku->id : 'buku/add'); ?>
            <!-- Hidden input for book ID, used only in edit mode -->
            <input type="hidden" name="id" value="<?php echo isset($buku) ? $buku->id : ''; ?>">

            <!-- Judul (Title) field -->
            <div class="mb-4">
                <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Judul:</label>
                <input type="text" id="judul" name="judul" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo isset($buku) ? htmlspecialchars($buku->judul) : set_value('judul'); ?>" required>
            </div>

            <!-- Penulis (Author) field -->
            <div class="mb-4">
                <label for="penulis" class="block text-gray-700 text-sm font-bold mb-2">Penulis:</label>
                <input type="text" id="penulis" name="penulis" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo isset($buku) ? htmlspecialchars($buku->penulis) : set_value('penulis'); ?>" required>
            </div>

            <!-- Tahun Terbit (Publication Year) field -->
            <div class="mb-4">
                <label for="tahun_terbit" class="block text-gray-700 text-sm font-bold mb-2">Tahun Terbit:</label>
                <input type="number" id="tahun_terbit" name="tahun_terbit" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo isset($buku) ? htmlspecialchars($buku->tahun_terbit) : set_value('tahun_terbit'); ?>" required>
            </div>

            <!-- ISBN field -->
            <div class="mb-6">
                <label for="isbn" class="block text-gray-700 text-sm font-bold mb-2">ISBN:</label>
                <input type="text" id="isbn" name="isbn" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo isset($buku) ? htmlspecialchars($buku->isbn) : set_value('isbn'); ?>" required>
            </div>

            <!-- Action buttons: Simpan (Save) and Batal (Cancel) -->
            <div class="flex items-center justify-start gap-4"> <!-- Use justify-start and gap for button alignment -->
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                    Simpan
                </button>
                <!-- Link to cancel and go back to the book list -->
                <a href="<?php echo site_url('buku'); ?>" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                    Batal
                </a>
            </div>
        <?php echo form_close(); ?>
    </div>
</body>
</html>