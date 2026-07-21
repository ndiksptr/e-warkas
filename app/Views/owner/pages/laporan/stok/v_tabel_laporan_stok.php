<table class="table table-bordered table-striped">
    <thead>
        <tr class="text-center bg-light">
            <th>No</th> 
            <th>Nama</th>
            <th>Harga</th>
            <th>Kategori</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1; 
        foreach ($datastok as $row) : 
        ?>
        <tr>
            <td class="text-center"><?= $no++; ?></td>
            <td><?= $row['product_name']; ?></td>            
            <td>Rp. <?= number_format($row['selling_price'], 0, ',', '.'); ?></td>            
            <td><?= $row['category_name']; ?></td>
            <td class="text-center"><?= $row['stock']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>