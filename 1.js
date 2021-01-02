let hitungUangKembalian = (param1, param2) => {
    let totalKembalian = param1 - param2
    let kembalian = []
    let pecahanUang = [
        100000,
        50000,
        20000,
        10000,
        5000,
        2000,
        1000,
        500,
        200,
        100
    ]

    for (let i = 0; totalKembalian > 0 && i < pecahanUang.length; i++) {
        let nilaiUang = pecahanUang[i]
        let jumlahUang

        if (nilaiUang <= totalKembalian) {
            jumlahUang = Math.floor(totalKembalian / nilaiUang)

            totalKembalian -= nilaiUang * jumlahUang

            kembalian.push({
                nilai: nilaiUang,
                jumlah: jumlahUang
            })
        }
    }

    console.log('Uang dibayar : ' + param1)
    console.log('Total bayar : ' + param2)
    
    console.log('================================================')

    for (let index in kembalian) {
        let satuanKembalian = kembalian[index];

        console.log('Uang pecahan Rp ' + satuanKembalian.nilai + ' sebanyak ' + satuanKembalian.jumlah)
    }

    console.log('================================================')

    totalKembalian = param1 - param2

    console.log('Kembalian : ' + totalKembalian)
    console.log('Terbilang : ')
}