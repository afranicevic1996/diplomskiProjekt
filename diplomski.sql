-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2020 at 03:13 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diplomski`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategorija`
--

CREATE TABLE `kategorija` (
  `id` int(11) NOT NULL,
  `naziv` varchar(50) NOT NULL,
  `komponenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategorija`
--

INSERT INTO `kategorija` (`id`, `naziv`, `komponenta`) VALUES
(1, 'Desktop računala', 0),
(2, 'Laptopi', 0),
(4, 'Mobiteli', 0),
(8, 'Matične ploče', 1),
(10, 'Procesori', 1),
(11, 'Periferija', 0),
(12, 'Potrošni materijal', 0),
(13, 'Grafičke kartice', 1),
(14, 'Memorije', 1),
(15, 'Napajanja', 1),
(16, 'Kučišta', 1),
(17, 'Optički uređaji', 1);

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

CREATE TABLE `komentari` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `komentar` varchar(200) NOT NULL,
  `ocjena` int(11) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`id`, `userID`, `productID`, `komentar`, `ocjena`, `username`) VALUES
(1, 19, 1, 'Odlicna kupovina', 4, 'novi'),
(3, 20, 1, 'Nije lose ali skupo.', 3, 'afrani');

-- --------------------------------------------------------

--
-- Table structure for table `kupovine`
--

CREATE TABLE `kupovine` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `kolicina` int(11) NOT NULL,
  `vrijeme` datetime NOT NULL,
  `cijenaKom` varchar(50) NOT NULL,
  `cijenaTotal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kupovine`
--

INSERT INTO `kupovine` (`id`, `userID`, `productID`, `kolicina`, `vrijeme`, `cijenaKom`, `cijenaTotal`) VALUES
(2, 19, 1, 1, '2020-06-22 17:19:15', '1250.60', '1250.6'),
(5, 20, 1, 3, '2020-06-23 11:03:48', '1250.60', '3751.8'),
(6, 19, 1, 3, '2020-06-26 20:37:34', '2830.00', '8490'),
(7, 19, 1, 3, '2020-06-26 20:38:26', '2830.00', '8490');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posebneakcije`
--

CREATE TABLE `posebneakcije` (
  `id` int(11) NOT NULL,
  `productID` varchar(50) NOT NULL,
  `fileName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posebneakcije`
--

INSERT INTO `posebneakcije` (`id`, `productID`, `fileName`) VALUES
(6, '33', '5cf79516d3.jpg'),
(7, '28', 'e21d0a041b.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `cijena` decimal(10,2) NOT NULL,
  `opis` varchar(1000) NOT NULL,
  `dostupnost` int(11) NOT NULL,
  `kategorija` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `naziv`, `cijena`, `opis`, `dostupnost`, `kategorija`) VALUES
(1, 'MSI X570 GODLIKE', '3130.00', 'Supports 2nd and 3rd Gen AMD Ryzen™ / Ryzen™ with Radeon™ Vega Graphics and 2nd Gen AMD Ryzen™ with Radeon™ Graphics Desktop Processors for AM4 socket Supports DDR4 Memory, up to 5000+(OC) MHzasasasas', 0, '8'),
(5, 'X570 AORUS ELITE (rev. 2.0)', '1329.00', 'AMD X570 AORUS Motherboard with 12+2 Phases Digital VRM with DrMOS, Advanced Thermal Design with Enlarge Heatsink, Dual PCIe 4.0 M.2 with Single Thermal Guard, Intel® GbE LAN with cFosSpeed, Front USB Type-C, RGB Fusion 2.0', 1, '8'),
(7, 'AMD Ryzen 5 3600', '1105.00', '# of CPU Cores 6\r\n# of Threads 12\r\nBase Clock 3.6GHz\r\nMax Boost Clock Up to 4.2GHz\r\nTotal L1 Cache 384KB\r\nTotal L2 Cache 3MB\r\nTotal L3 Cache 32MB\r\nUnlocked Yes\r\nCMOS TSMC 7nm FinFET\r\nPackage AM4\r\nPCI Express® Version PCIe 4.0 x16\r\nThermal Solution (PIB) Wraith Stealth\r\nThermal Solution (MPK) Wraith Stealth\r\nDefault TDP / TDP 65W\r\nMax Temps 95°C', 1, '10'),
(8, 'AMD Ryzen 7 2700', '1395.00', '# of CPU Cores 8\r\n# of Threads 16\r\nBase Clock 3.2GHz\r\nMax Boost Clock  Up to 4.1GHz\r\nTotal L1 Cache 768KB\r\nTotal L2 Cache 4MB\r\nTotal L3 Cache 16MB\r\nUnlocked Yes\r\nCMOS 12nm FinFET\r\nPackage AM4\r\nPCI Express® Version PCIe 3.0 x16\r\nThermal Solution (PIB) Wraith Spire with RGB LED\r\nThermal Solution (MPK) Wraith Spire\r\nDefault TDP / TDP 65W\r\nMax Temps 95°C', 1, '10'),
(9, 'AMD Ryzen 7 3700x', '1728.00', '3rd Gen Ryzen Socket AM4 Max Boost Frequency 4.4 GHz DDR4 Support L2 Cache 4MB L3 Cache 32MB\r\nThermal Design Power 65W With Wraith Prism cooler', 0, '10'),
(10, 'Intel Core i9-9900K', '3120.00', '9th Gen Intel Processor Intel UHD Graphics 630 Only Compatible with Intel 300 Series Motherboard Socket LGA 1151 (300 Series) Max Turbo Frequency 5.0 GHz\r\nUnlocked Processor DDR4 Support Intel Optane Memory and SSD Supported Cooling device not included - Processor Only\r\nIntel Turbo Boost Technology 2.0 and Intel vPro technology offer pro-level performance for gaming, creating, and overall productivity', 1, '10'),
(11, 'Intel Core i7-9700K', '2817.00', '9th Gen Intel Processor Intel UHD Graphics 630 Only Compatible with Intel 300 Series Motherboard Socket LGA 1151 (300 Series)\r\nMax Turbo Frequency 4.9 GHz Unlocked Processor DDR4 Support Intel Optane Memory and SSD Supported\r\nCooling device not included - Processor Only Intel Turbo Boost Technology 2.0 and Intel vPro technology offer high performance for enthusiast gaming, creating, and overclocking', 1, '10'),
(12, 'Intel Core i9-10900K', '3321.00', '14nm 125W\r\n20MB L3 Cache\r\nIntel UHD Graphics 630', 0, '10'),
(13, 'Intel Core i5-9600K', '1420.00', '9th Gen Intel Processor Intel UHD Graphics 630 Only Compatible with Intel 300 Series Motherboard Socket LGA 1151 (300 Series)\r\nProcessor Base Frequency 3.7 GHz Unlocked Processor DDR4 Support Intel Optane Memory and SSD Supported Cooling device not included - Processor Only\r\nIntel Turbo Boost Technology 2.0 and Intel vPro technology offer powerful productivity, gaming, and overclocking', 1, '10'),
(14, 'AMD Ryzen 9 3950X', '4203.00', '3rd Gen Ryzen Socket AM4 Max Boost Frequency 4.7 GHz DDR4 Support\r\nL2 Cache 8MB L3 Cache 64MB Thermal Design Power 105W', 1, '10'),
(15, 'AMD Ryzen 7 3800X', '1951.00', '3rd Gen Ryzen Socket AM4 Max Boost Frequency 4.5 GHz DDR4 Support\r\nL2 Cache 4MB L3 Cache 32MB Thermal Design Power 105W With Wraith Prism cooler', 1, '10'),
(16, 'AMD Ryzen 5 3600X', '1320.00', '3rd Gen Ryzen Socket AM4 Max Boost Frequency 4.4 GHz DDR4 Support\r\nL2 Cache 3MB L3 Cache 32MB Thermal Design Power 95W With Wraith Spire cooler', 1, '10'),
(17, 'Gigabyte nVidia GT1030 2GB OC', '735.00', 'Chip: GP108-300-A1 \"Pascal\" • Chip clock: 1290MHz, Boost: 1544MHz (OC Mode) • Memory: 2GB GDDR5, 1500MHz, 64bit, 48GB/s • Shader Units/TMUs/ROPs: 384/24/8 • computing power: 1186GFLOPS (Single), 37GFLOPS (Double) • Manufacturing process: 14nm • Power consumption: 30W (TDP), not specified (idle) • DirectX: 12.1 • OpenGL: 4.5 • OpenCL: 1.2 • Vulkan: 1.0 • Shader model: 5.0 • Interface: PCIe 3.0 x16 • Total height: dual-slot • Cooling: 1x Axial-fan (80mm) • Connectors: 1x DVI, 1x HDMI 2.0b • external Power supply: not available • Dimensions: 168x111x27mm • Special features: H.265 encode/decode, HDCP 2.2, base clock overclocked (+63MHz), boost clock overclocked (+76MHz) • Warranty: three years (handling by merchant) • Note: OC Mode unlockable via GPU Tweak II. Factory default clock: 1252MHz/1506MHz (Gaming Mode)', 1, '13'),
(18, 'Gainward nVidia GTX1050Ti 4GB, GDDR5', '1169.00', 'Chip: GP107-400-A1 \"Pascal\" • Chip clock: 1290MHz, Boost: 1392MHz • Memory: 4GB GDDR5, 1750MHz, 128bit, 112GB/s • Shader Units/TMUs/ROPs: 768/48/32 • computing power: 2138GFLOPS (Single), 67GFLOPS (Double) • Manufacturing process: 14nm • Power consumption: 75W (TDP), 5.98W (idle, measured) • DirectX: 12.1 • OpenGL: 4.6 • OpenCL: 1.2 • Vulkan: 1.0 • Shader model: 5.0 • Interface: PCIe 3.0 x16 • Total height: dual-slot • Cooling: 1x Axial-fan (80mm) • Connectors: 1x DVI, 1x HDMI 2.0b, 1x DisplayPort 1.4 • external Power supply: not available • Dimensions: 161x112mm • Special features: H.265 encode/decode, NVIDIA G-Sync, HDCP 2.2', 1, '13'),
(19, 'Palit nVidia GTX1050TI 4GB StormX', '1188.00', 'Connectors 1x DVI, 1x HDMI 2.0b, 1x DisplayPort 1.4\r\nChip GP107-400-A1 \"Pascal\"\r\nManufacturing process 14nm\r\nChip clock 1290MHz, Boost: 1392MHz\r\nMemory 4GB GDDR5, 1750MHz, 128bit, 112GB/s\r\nShader Units/TMUs/ROPs 768/48/32\r\nTDP 75W (NVIDIA)\r\nExternal power supply not available\r\nCooling 1x Axial-fan (80mm)\r\nTotal height dual-slot\r\nDimensions 166x112x39mm\r\nSpecial features H.265 encode/decode, NVIDIA G-Sync, HDCP 2.2\r\nInterface PCIe 3.0 x16\r\ncomputing power 2138GFLOPS (Single), 67GFLOPS (Double)\r\nDirectX 12.1\r\nOpenGL 4.6\r\nOpenCL 1.2\r\nVulkan 1.0\r\nShader model 5.0', 0, '13'),
(20, 'Sapphire AMD RX570 Pulse ITX, 4GB DDR5, Lite retail', '1199.00', 'Connectors 1x DVI, 1x HDMI 2.0b, 1x DisplayPort 1.4\r\nChip Polaris 20 XL (Ellesmere XL) \"GCN 4\"\r\nManufacturing process 14nm\r\nChip clock 1168MHz, Boost: 1244MHz\r\nMemory 4GB GDDR5, 1500MHz, 256bit, 192GB/s\r\nShader Units/TMUs/ROPs 2048/128/32\r\nTDP 150W (AMD), 150W (Sapphire)\r\nExternal power supply 1x 6-Pin PCIe\r\nCooling 1x Axial-fan (95mm)\r\nTotal height dual-slot\r\nDimensions 170x112x36mm\r\nSpecial features H.265 encode/decode, AMD FreeSync, AMD Trueaudio, AMD Eyefinity, 2-Way-CrossFireX, HDCP 2.2\r\nInterface PCIe 3.0 x16\r\ncomputing power 5095GFLOPS (Single), 318GFLOPS (Double)\r\nDirectX 12.0\r\nOpenGL 4.6\r\nOpenCL 2.0\r\nVulkan 1.1.86\r\nShader model 6.0\r\nWarranty three years', 1, '13'),
(21, 'Gainward nVidia GTX1650 Pegasus 4GB, 4GB GDDR5', '1249.00', 'Connectors 1x DVI, 1x HDMI 2.0b\r\nGraphics NVIDIA GeForce GTX 1650 (Desktop), 4GB GDDR5\r\nChip TU117-300-A1 \"Turing\"\r\nManufacturing process 12nm (TSMC)\r\nChip clock 1485MHz, Boost: 1725MHz\r\nMemory 4GB GDDR5, 2000MHz, 128bit, 128GB/s\r\nShader Units/TMUs/ROPs 896/56/32\r\nTDP 75W (NVIDIA), 75W (Gainward)\r\nexternal power supply not available\r\nCooling 1x Axial-fan (70mm)\r\ntotal height dual-slot\r\nDimensions 145x99mm\r\nSpecial features H.265 encode/decode, NVIDIA G-Sync, NVIDIA VR-Ready, HDCP 2.2, boost clock overclocked (+60MHz)\r\nInterface PCIe 3.0 x16\r\nComputing power 3.09 TFLOPS (FP32), 97 GFLOPS (FP64)\r\nDirectX 12 (12_1)\r\nOpenGL 4.6\r\nOpenCL 1.2\r\nVulkan 1.2\r\nShader model 6.5', 1, '13'),
(22, 'Gigabyte nVidia GTX1650 4GB OC, GDDR5', '1279.00', 'Connectors 2x HDMI 2.0b, 1x DisplayPort 1.4a\r\nChip TU117-300-A1 \"Turing\"\r\nManufacturing process 12nm\r\nChip clock 1485MHz, Boost: 1710MHz\r\nMemory 4GB GDDR5, 2000MHz, 128bit, 128GB/s\r\nShader Units/TMUs/ROPs 896/56/32\r\nTDP 75W (NVIDIA)\r\nExternal power supply not available\r\nCooling 2x Axial-fan (80mm)\r\nTotal height dual-slot\r\nDimensions 191x112x36mm\r\nSpecial features H.265 encode/decode, NVIDIA G-Sync, NVIDIA VR-Ready, HDCP 2.2, 0dB-zero-fan-mode, boost clock overclocked (+45MHz)\r\nInterface PCIe 3.0 x16\r\ncomputing power 3064GFLOPS (Single), 96GFLOPS (Double)\r\nDirectX 12.1\r\nOpenGL 4.6\r\nOpenCL 2.0\r\nVulkan 1.1.103\r\nShader model 6.3', 1, '13'),
(23, 'XFX AMD RX570 8GB RS XXX Edition', '1296.00', 'Chip: Polaris 20 XL (Ellesmere XL) \"GCN Gen4\" • Chip clock: 1168MHz, Boost: 1284MHz (OC+ Clock) • Memory: 8GB GDDR5, 1775MHz, 256bit, 227GB/s • Shader Units/TMUs/ROPs: 2048/128/32 • computing power: 5259GFLOPS (Single), 329GFLOPS (Double) • Manufacturing process: 14nm • Power consumption: 150W (TDP), not specified (idle), 3W (ZeroCore-Power) • DirectX: 12.0 • OpenGL: 4.5 • OpenCL: 2.0 • Vulkan: 1.0 • Shader model: 5.0 • Interface: PCIe 3.0 x16 • Total height: dual-slot • Cooling: 2x Axial-fan (90mm) • Connectors: 1x DVI, 1x HDMI 2.0b, 3x DisplayPort 1.4 • external Power supply: 1x 8-Pin PCIe • Dimensions: 243x124x40mm • Special features: H.265 encode/decode, VP9 encode/decode, AMD FreeSync, AMD Trueaudio, AMD Eyefinity, 2-Way-CrossFireX, HDCP 2.2, zero-fan-mode, Backplate, boost clock overclocked (+40MHz) • Warranty: three years (handling by merchant or manufacturer) • Note: OC+ Clock configurable via AMD Wattman. Factory default clock: 1168MHz/1264MHz (True Clock)', 1, '13'),
(24, 'ASUS nVidia GTX1650 TUF-GTX1650-4G-GAMING', '1341.00', 'Connectors 1x DVI, 1x HDMI 2.0b, 1x DisplayPort 1.4a\r\nGraphics NVIDIA GeForce GTX 1650 (Desktop), 4GB GDDR5\r\nChip TU117-300-A1 \"Turing\"\r\nManufacturing process 12nm (TSMC)\r\nChip clock 1515MHz, Boost: 1695MHz (OC Mode)\r\nMemory 4GB GDDR5, 2000MHz, 128bit, 128GB/s\r\nShader Units/TMUs/ROPs 896/56/32\r\nTDP 75W (NVIDIA)\r\nExternal power supply not available\r\nCooling 2x Axial-fan (80mm)\r\nTotal height dual-slot\r\nDimensions 200x112x47mm\r\nSpecial features H.265 encode/decode, NVIDIA G-Sync, NVIDIA VR-Ready, Backplate, base clock overclocked (+30MHz), boost clock overclocked (+30MHz)\r\nInterface PCIe 3.0 x16\r\nComputing power 3.04 TFLOPS (FP32), 95 GFLOPS (FP64)\r\nDirectX 12 (12_1)\r\nOpenGL 4.6\r\nOpenCL 1.2\r\nVulkan 1.2\r\nShader model 6.5', 0, '13'),
(25, 'MSI nVidia GT710 1GD3H LP, 1GB DDR3', '349.18', 'Connectors 1x VGA, 1x DVI, 1x HDMI 1.4\r\nModel NVIDIA GeForce GT 710\r\nChip GK208-203-B1 64bit \"Kepler 2.0\"\r\nManufacturing process 28nm (TSMC)\r\nChip clock 954MHz, Boost: not available\r\nMemory 1GB DDR3, 800MHz, 64bit, 12.8GB/s\r\nShader Units/TMUs/ROPs 192/16/8\r\nTDP 19W (NVIDIA)\r\nExternal power supply not available\r\nCooling passive\r\nTotal height single-slot\r\nDimensions 146x69x19mm\r\nSpecial features low profile design\r\nInterface PCIe 2.0 x16 (x8)\r\nComputing power 366GFLOPS (Single), 15GFLOPS (Double)\r\nDirectX 11.0\r\nOpenGL 4.6\r\nOpenCL 1.2\r\nVulkan 1.0\r\nShader model 5.0', 1, '13'),
(26, 'ASUS nVidia GT730-SL-2GD5-BRK', '560.00', 'Chip: GK208-300-A1 - GeForce GT 730 \"Kepler 2.0\" • Chip clock: 902MHz, Boost: not available • Memory: 2GB DDR3, 800MHz, 64bit, 12.8GB/s • Shader Units/TMUs/ROPs: 384/16/8 • computing power: 693GFLOPS (Single), 29GFLOPS (Double) • Manufacturing process: 28nm • Power consumption: 38W (TDP), not specified (idle) • DirectX: 11.0 • OpenGL: 4.6 • OpenCL: 1.2 • Vulkan: 1.0 • Shader model: 5.0 • Interface: PCIe 2.0 x8 • Total height: dual-slot • Cooling: passive • Connectors: 1x VGA, 1x DVI, 1x HDMI 1.4 • external Power supply: not available • Dimensions: 137x69x30mm • Special features: low profile Design', 1, '13'),
(27, 'ASUS nVidia GTX1050TI STRIX-GTX1050TI-4G-GAMING', '1458.00', 'Chip: GP107-400-A1 \"Pascal\" • Chip clock: 1290MHz, Boost: 1392MHz • Memory: 4GB GDDR5, 1750MHz, 128bit, 112GB/s • Shader Units/TMUs/ROPs: 768/48/32 • computing power: 2138GFLOPS (Single), 67GFLOPS (Double) • Manufacturing process: 14nm • Power consumption: 75W (TDP), 5.98W (idle, measured) • DirectX: 12.0 (Feature-Level 12-1) • OpenGL: 4.5 • OpenCL: 1.2 • Vulkan: 1.0 • Shader model: 5.0 • Interface: PCIe 3.0 x16 • Total height: dual-slot • Cooling: 2x Axial-fan (100mm) • Connectors: 2x DVI, HDMI 2.0b, DisplayPort 1.4 • external Power supply: 1x 6-Pin PCIe • Dimensions: 241x129x40mm • Special features: H.265 encode/decode, NVIDIA G-Sync, NVIDIA VR-Ready, HDCP 2.2, Zero-Fan mode (up to 55°C), Backplate, fan control (2x 4-Pin), LED lighting (RGB)', 1, '13'),
(28, 'MSI AMD RX5500XT Mech 4G OC, 4GB GDDR6', '1599.00', 'Connectors 1x HDMI 2.0b, 3x DisplayPort 1.4\r\nModel AMD Radeon RX 5500 XT (Desktop), 4GB GDDR6\r\nChip Navi 14 XTX \"RDNA 1.0\"\r\nManufacturing process 7nm (TSMC)\r\nChip clock 1647MHz, Boost: 1733-1845MHz\r\nMemory 4GB GDDR6, 1750MHz, 128bit, 224GB/?s\r\nShader Units/TMUs/ROPs 1408/?88/?32\r\nTDP 130W (AMD), 140W (MSI)\r\nExternal power supply 1x 8-Pin PCIe\r\nCooling 2x Axial-fan (90mm)\r\nTotal height dual-slot\r\nDimensions 215x128x40mm\r\nSpecial features H.264 encode/?decode, H.265 encode/?decode, VP9 encode/?decode, AMD FreeSync, AMD Trueaudio Next, AMD Eyefinity, HDCP 2.2, Backplate, base clock overclocked (+40MHz)\r\nInterface PCIe 4.0 x16 (x8)\r\nComputing power 5.2 TFLOPS (FP32), 325 GFLOPS (FP64)\r\nDirectX 12.0 (12_1)\r\nOpenGL 4.6\r\nOpenCL 2.0\r\nVulkan 1.1.119\r\nShader model 6.4', 1, '13'),
(29, 'MSI AMD RX5700 GAMING X, 8GB GDDR6', '3474.00', 'Connectors 1x HDMI 2.0b, 3x DisplayPort 1.4\r\nModel AMD Radeon RX 5700\r\nChip Navi 10 XL \"AMD RDNA 1.0\"\r\nManufacturing process 7nm (TSMC)\r\nChip clock 1610MHz, Boost: 1750MHz\r\nMemory 8GB GDDR6, 1750MHz, 256bit, 448GB/s\r\nShader Units/TMUs/ROPs 2304/144/64\r\nTDP 180W (AMD), 225W (MSI)\r\nExternal power supply 2x 8-Pin PCIe\r\nCooling 2x Axial-fan (100mm)\r\nTotal height triple-slot\r\nDimensions 297x140x58mm\r\nSpecial features H.264 encode/decode, H.265 encode/decode, VP9 encode/decode, AMD FreeSync, AMD Trueaudio Next, AMD Eyefinity, HDCP 2.2, 0dB-zero-fan-mode (up to 60°C), Backplate, LED lighting (RGB), base clock overclocked (+145MHz), boost clock overclocked (+25MHz)\r\nInterface PCIe 4.0 x16\r\nComputing power 8064GFLOPS (Single), 504GFLOPS (Double)\r\nDirectX 12.1\r\nOpenGL 4.6\r\nOpenCL 2.0\r\nVulkan 1.1\r\nShader model 6.4', 0, '13'),
(30, 'Zotac nVidia RTX2070 Gaming OC MINI, 8GB GDDR6', '4500.00', 'Connectors 1x DVI, 1x HDMI 2.0b, 3x DisplayPort 1.4\r\nChip TU106-400X-A1 \"Turing\"\r\nManufacturing process 12nm\r\nChip clock 1410MHz, Boost: 1650MHz\r\nMemory 8GB GDDR6, 1750MHz, 256bit, 448GB/s\r\nShader Units/TMUs/ROPs 2304/144/64\r\nTDP 175W (NVIDIA), 175W (Zotac)\r\nExternal power supply 1x 8-Pin PCIe\r\nCooling 2x Axial-fan (100mm + 90mm)\r\nTotal height dual-slot\r\nDimensions 211x129x41mm\r\nSpecial features Real-Time Ray Tracing (6GRays/s), Raytracing Cores (36), Tensor Cores (288), H.265 encode/decode, NVIDIA G-Sync, NVIDIA VR-Ready, HDCP 2.2, Backplate, LED lighting (white), boost clock overclocked (+30MHz)\r\nInterface PCIe 3.0 x16\r\ncomputing power 7603GFLOPS (Single), 238GFLOPS (Double)\r\nDirectX 12.1\r\nOpenGL 4.6\r\nOpenCL 2.0\r\nVulkan 1.1.92\r\nShader model 6.3\r\n\r\nWarranty five years after registration (within 28 days of purchase, Standard: two years, handling by merchant or Manufacturer, warranty expires after second year in case of cooler teardown)', 1, '13'),
(31, 'EVGA nVidia RTX2070 SUPER KO Gaming, 8GB GDDR6', '5080.32', 'Connectors 1x HDMI 2.0b, 3x DisplayPort 1.4a\r\nGraphics NVIDIA GeForce RTX 2070 SUPER (Desktop), 8GB GDDR6\r\nChip TU104-410-A1 \"Turing\"\r\nManufacturing process 12nm (TSMC)\r\nChip clock 1605MHz, Boost: 1770MHz\r\nMemory 8GB GDDR6, 1750MHz, 256bit, 448GB/s\r\nShader Units/TMUs/ROPs 2560/160/64\r\nTDP 215W (NVIDIA), 215W (EVGA)\r\nexternal power supply 1x 8-Pin PCIe, 1x 6-Pin PCIe\r\nCooling 2x Axial-fan (90mm)\r\ntotal height dual-slot\r\nDimensions 270x111mm\r\nSpecial features Real-Time Ray Tracing (7GRays/s), Raytracing Cores (40), Tensor Cores (320), H.265 encode/decode, NVIDIA G-Sync, NVIDIA VR-Ready, HDCP 2.2, 0dB-zero-fan-mode\r\nInterface PCIe 3.0 x16\r\nComputing power 9.06 TFLOPS (FP32), 283 GFLOPS (FP64)\r\nDirectX 12 Ultimate (12_1)\r\nOpenGL 4.6\r\nOpenCL 1.2\r\nVulkan 1.2\r\nShader model 6.5', 1, '13'),
(32, 'INNO3D nVidia GT730, [GK208] passive, 2GB DDR3', '570.00', 'Connectors 1x VGA, 1x DVI, 1x HDMI 1.4\r\nChip GK208-300-A1 - GeForce GT 730 \"Kepler 2.0\"\r\nManufacturing process 28nm\r\nChip clock 902MHz, Boost: not available\r\nMemory 2GB DDR3, 800MHz, 64bit, 12.8GB/s\r\nShader Units/TMUs/ROPs 384/16/8\r\nTDP 38W (NVIDIA)\r\nExternal power supply not available\r\nCooling passive\r\nTotal height dual-slot\r\nDimensions 140x70mm\r\nSpecial features low profile design\r\nInterface PCIe 2.0 x16 (x8)\r\ncomputing power 693GFLOPS (Single), 29GFLOPS (Double)\r\nDirectX 11.0\r\nOpenGL 4.6\r\nOpenCL 1.2\r\nVulkan 1.0\r\nShader model 5.0', 0, '13'),
(33, 'Lenovo V530 MT', '2382.00', 'CPU Intel Pentium Gold G5400, 2x 3.70GHz\r\nRAM 4GB DDR4-2666 (1x 4GB module, 2 Slots, max. 32GB)\r\nHDD 1TB\r\nSSD none\r\nOptical drive DVD+/-RW DL\r\nGraphics Intel HD Graphics 610 (IGP), 1x VGA, 1x HDMI, 1x DisplayPort\r\nConnectors 2x USB-A 3.1, 6x USB-A 3.0, 2x USB-A 2.0, 1x Gb LAN, 5x jack, 1x serial\r\nCard Readers SD-Card, MMC, Memory Stick\r\nWireless -\r\nOperating system -\r\nMonitor not available\r\nDimensions (WxHxD) 147x360x276mm\r\nSpecial features keyboard and mouse included, security lock (Kensington), EPEAT Silver\r\nWarranty three years', 1, '1'),
(34, 'HP ProDesk 400 G5 DM', '4429.00', 'CPU Intel Core i5-9500T, 6x 2.20GHz\r\nRAM 8GB DDR4-2666 SO-DIMM (1x 8GB module, 2 Slots)\r\nHDD not available\r\nSSD 256GB M.2 PCIe\r\nOptical drive not available\r\nGraphics Intel UHD Graphics 630 (IGP)\r\nConnectors 2x DisplayPort 1.2, 4x USB-A 3.0, 2x USB-A 2.0, 1x Gb LAN (Realtek RTL8111HSH), 2x jack\r\ncard readers not available\r\nWireless not available\r\nOperating system Windows 10 Pro 64bit\r\nMonitor not available\r\nDimensions (WxHxD) 177x34x175mm\r\nSpecial features keyboard and mouse included, External power supply\r\nColour black/?silver', 0, '1'),
(35, 'DELL Poweredge T130 MT', '5799.00', 'T130,Intel Xeon E3-1225 v6 3.0GHz 8M cache, 4C/4T turbo, 8GB UDIMM 2400MT/s, Chassis with up to 4, 3.5 Cabled Hard Drives , iDRAC8 basic, 2x 1TB 7.2K RPM SATA 6Gbps 3.5in, DVD+/-RW, On-Board LOM 1GBE Dual Port, 3Yr Basic Warranty', 1, '1'),
(36, 'Lenovo IdeaPad L340-15API, 81LW0049SC', '3499.00', 'opis', 1, '2'),
(37, 'DELL Inspiron 3579 - G3', '5799.00', 'CPU: Intel Core procesor i5-8300H\r\n2.3GHz - 4.0GHz / 8MB Smart Cache / 4 Cores\r\nDisplay: 15.6\" FHD IPS LED Anti-Glare (1920 x 1080), with integrated HD camera\r\nRAM: 8GB (1x8) 2666MHz DDR4 memory\r\nHard Disk: M.2 SATA 256GB Solid State Drive\r\nVideo: nVidia GeForce GTX 1050 4GB GDDR5\r\nAudio: 2 tuned speakers with Waves MaxxAudio Pro\r\nNetwork: 10/100/1000Mbps network adapter\r\nWLAN: Intel 9462 802.11ac, Dual Band 2.4&5 GHz, 2x2\r\nBluetooth: Bluetooth 5.0 adapter\r\nI/O ports: 2x USB 3.1, 1x HDMI 2.0, 1x audio, 1x RJ45\r\nI/O slots: Media Card reader, Internal M.2 - PCIe/SATA\r\nKeyboard: CRO layout, numeric keypad, Backlit, integrated Touch Pad\r\nPower supply: Li-Ion battery 56Whr, AC adapter\r\nOS: Linux Ubuntu 16.04\r\nWeight: 2.53 kg\r\nColor: Black', 1, '2');

-- --------------------------------------------------------

--
-- Table structure for table `resetpassword`
--

CREATE TABLE `resetpassword` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kod` varchar(20) NOT NULL,
  `iskoristen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resetpassword`
--

INSERT INTO `resetpassword` (`id`, `username`, `email`, `kod`, `iskoristen`) VALUES
(5, 'novi', 'karamelpls@gmail.com', '95547129', 0),
(6, 'novi', 'karamelpls@gmail.com', '40078561', 0),
(7, 'novi', 'karamelpls@gmail.com', '42744430', 0),
(8, 'novi', 'karamelpls@gmail.com', '03083769', 0),
(9, 'novi', 'karamelpls@gmail.com', '69932047', 0),
(10, 'novi', 'karamelpls@gmail.com', '84771894', 0),
(11, 'kanarinac', 'kanarinac123@gmail.com', '85687415', 1),
(12, 'kanarinac', 'kanarinac123@gmail.com', '69488812', 1);

-- --------------------------------------------------------

--
-- Table structure for table `slike`
--

CREATE TABLE `slike` (
  `id` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `fileName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slike`
--

INSERT INTO `slike` (`id`, `productID`, `fileName`) VALUES
(1, 1, 'meg1.jpg'),
(2, 1, 'meg2.jpg'),
(3, 1, 'meg3.jpg'),
(4, 4, 'bf974f5e22.png'),
(5, 4, 'd891ed0e7c.jpg'),
(6, 5, '5f18a9e028.jpg'),
(7, 5, 'c0ed75ecd7.jpg'),
(8, 6, '5794d49828.png'),
(9, 7, 'c9b5e8838c.jpg'),
(10, 7, 'e6d9a81c10.jpg'),
(11, 7, 'a5f340c72c.jpg'),
(12, 8, '1f450cb42b.jpg'),
(13, 8, 'deb7f5c85f.jpg'),
(14, 9, 'e54d182e0a.jpg'),
(15, 9, 'e836714aac.jpg'),
(16, 10, 'f143476907.jpg'),
(17, 10, '5d33a70527.jpg'),
(18, 11, '398212fee9.jpg'),
(19, 11, 'fbdb018450.jpg'),
(20, 12, 'be46a1e825.jpg'),
(21, 12, 'ed835c2ffe.jpg'),
(22, 13, '7f79d051a6.jpg'),
(23, 13, 'cecf534139.jpg'),
(24, 14, '689fa03562.jpg'),
(25, 14, 'e0622482a7.jpg'),
(26, 14, '19d8b9494b.jpg'),
(27, 15, '5214627f02.jpg'),
(28, 15, '39e3645b1d.jpg'),
(29, 15, '23ec172664.jpg'),
(30, 16, 'fa7e600a66.jpg'),
(31, 16, '8c468121e5.jpg'),
(32, 16, 'ea22421de1.jpg'),
(33, 17, '2956d404a9.jpg'),
(34, 18, 'e98c1a09f8.jpg'),
(35, 18, '22773c4ce2.jpg'),
(36, 19, '0853a57444.jpg'),
(37, 19, '2153614130.jpg'),
(38, 20, 'df0de9dcfe.jpg'),
(39, 20, '73af5aaf0a.jpg'),
(40, 21, '34a2599d91.jpg'),
(41, 21, '0da1ea5b76.jpg'),
(42, 22, '143935e85a.jpg'),
(43, 23, '2eb797392f.jpg'),
(44, 23, 'a3a4318bca.jpg'),
(45, 24, 'e18939029a.jpg'),
(46, 24, '7611942643.jpg'),
(47, 25, '30e0f17aa8.jpg'),
(48, 26, '7644efb453.jpg'),
(49, 27, '1f613016a4.jpg'),
(50, 27, 'd7290d772c.jpg'),
(51, 28, 'd265444092.jpg'),
(52, 28, 'd1ad7cd152.jpg'),
(53, 29, '4031185c26.jpg'),
(54, 29, '71bb39112c.jpg'),
(55, 30, '3a1b7ea4aa.jpg'),
(56, 30, '3b04159bc1.jpg'),
(57, 31, 'bec023ee9c.jpg'),
(58, 31, '282d0af7eb.jpg'),
(59, 32, 'efa892ce49.jpg'),
(60, 33, '554961327d.jpg'),
(61, 34, '650885ea32.jpg'),
(62, 35, 'ac24fd1212.jpg'),
(63, 36, '3ed710128c.jpg'),
(64, 37, '3b8ffd4957.jpg'),
(65, 38, '27b20e79d8.jpg'),
(66, 39, '8cc69973b1.jpg'),
(67, 40, 'bf974f5e22.png'),
(68, 41, 'a4f65ad9f5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `ime` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prezime` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `telefon` varchar(100) DEFAULT NULL,
  `adresa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pbroj` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ime`, `prezime`, `email`, `password`, `username`, `telefon`, `adresa`, `pbroj`, `role`) VALUES
(18, 'Antonio', 'Franičević', 'kanarinac123@gmail.com', 'passw123', 'afrani', '0915144466', 'neka adresa 127', '21329', 'user'),
(19, 'neko', 'ime', 'karamelpls@gmail.com', 'novi', 'novi', '0917308889', 'nova adresa 21', '22000', 'user'),
(21, '', '', '', 'admin', 'admin', NULL, '', '', 'admin'),
(24, '', '', '', 'admin', 'admin123', '', '', '', 'admin'),
(26, 'korisnik', 'drugi', 'proba@proba.com', 'passw123', 'kanarinac', '', '', '', 'user'),
(27, 'novoime', 'novoprezime', 'asasasas@g.com', '1234', 'acc2', '', '', '', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `clicks` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `productID`, `clicks`) VALUES
(1, 1, '10'),
(2, 5, '10'),
(3, 7, '4'),
(4, 11, '3'),
(5, 14, '3'),
(6, 15, '1'),
(7, 10, '2'),
(8, 13, '2'),
(9, 8, '1'),
(10, 17, '3'),
(11, 30, '1'),
(12, 33, '3'),
(13, 36, '1'),
(17, 28, '3'),
(18, 27, '1'),
(19, 41, '1');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `userID`, `productID`) VALUES
(4, 18, 1),
(12, 19, 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategorija`
--
ALTER TABLE `kategorija`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komentari`
--
ALTER TABLE `komentari`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kupovine`
--
ALTER TABLE `kupovine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posebneakcije`
--
ALTER TABLE `posebneakcije`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resetpassword`
--
ALTER TABLE `resetpassword`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slike`
--
ALTER TABLE `slike`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorija`
--
ALTER TABLE `kategorija`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `komentari`
--
ALTER TABLE `komentari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kupovine`
--
ALTER TABLE `kupovine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posebneakcije`
--
ALTER TABLE `posebneakcije`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `resetpassword`
--
ALTER TABLE `resetpassword`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `slike`
--
ALTER TABLE `slike`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
