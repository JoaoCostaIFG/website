import type { Metadata } from "next";
import { Geist, Geist_Mono } from "next/font/google";
import "@/app/globals.css";
import Footer from "@/app/ui/footer";
import Navbar from "@/app/ui/navbar";

const geistSans = Geist({
  variable: "--font-geist-sans",
  subsets: ["latin"],
});

const geistMono = Geist_Mono({
  variable: "--font-geist-mono",
  subsets: ["latin"],
});

export const metadata: Metadata = {
  title: "Joao Costa",
  description: "Hey! I am a software engineer and this is my personal website. I try to be active here.",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <body
        className={`${geistSans.variable} ${geistMono.variable} antialiased bg-zinc-900 min-h-screen`}
      >
        <Navbar />

        <div id="content-container" className="bg-zinc-800 text-gray-50 container py-4 sm:rounded-b">
          {children}
        </div>

        <Footer />
      </body>
    </html>
  );
}
