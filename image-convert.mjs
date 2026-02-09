import fs from 'fs';
import path from 'path';
import sharp from 'sharp';
import chokidar from 'chokidar';

const inputDir = './src/assets/images'; // PNG画像が保存されるディレクトリ
const outputDir = './src/public/images'; // 変換後の画像を保存するディレクトリ

// 出力ディレクトリが存在しない場合は作成
if (!fs.existsSync(outputDir)){
    fs.mkdirSync(outputDir);
}

// ファイルを変換する関数
const convertImage = (filePath) => {
    const fileName = path.basename(filePath);
    const outputFilePathWebp = path.join(outputDir, fileName.replace(/\.(jpe?g|png)$/, '.webp'));
    const outputFilePathAvif = path.join(outputDir, fileName.replace(/\.(jpe?g|png)$/, '.avif'));

    // WebPに変換
    sharp(filePath)
        .webp()
        .toFile(outputFilePathWebp, (err, info) => {
            if (err) {
                console.error('Error converting to WebP:', err);
                return;
            }
            console.log(`Converted ${fileName} to WebP format`);
        });

    // AVIFに変換
    sharp(filePath)
        .avif()
        .toFile(outputFilePathAvif, (err, info) => {
            if (err) {
                console.error('Error converting to AVIF:', err);
                return;
            }
            console.log(`Converted ${fileName} to AVIF format`);
        });
};

// Chokidarでディレクトリを監視
chokidar.watch(inputDir, { persistent: true })
    .on('add', (filePath) => {
        const extname = path.extname(filePath).toLowerCase();
        if (extname === '.png' || extname === '.jpeg' || extname === '.jpg') {
            console.log(`File ${filePath} has been added`);
            convertImage(filePath);
        }
    })
    .on('error', (error) => {
        console.error('Error happened', error);
    });

console.log(`Watching for file changes in ${inputDir}`);
