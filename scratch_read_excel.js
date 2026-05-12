const xlsx = require('xlsx');

// Load the workbook
const workbook = xlsx.readFile('C:\\Users\\Asus\\Downloads\\perhitungan_singkat_RB PLO_2023.xlsx');

// Loop through each sheet
workbook.SheetNames.forEach(sheetName => {
    console.log(`\n--- Sheet: ${sheetName} ---`);
    const sheet = workbook.Sheets[sheetName];
    // Convert to JSON and take the first 5 rows
    const data = xlsx.utils.sheet_to_json(sheet, { header: 1 });
    console.log(JSON.stringify(data.slice(0, 10), null, 2));
});
