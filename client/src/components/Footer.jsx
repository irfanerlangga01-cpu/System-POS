import React from 'react';
import { motion } from 'framer-motion';
import { Linkedin, Twitter, Instagram, Facebook, Mail, Phone, MapPin } from 'lucide-react';

const Footer = () => {
  return (
    <footer className="bg-white text-dark-navy pt-20 pb-8">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid gap-10 lg:grid-cols-4 mb-12">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            viewport={{ once: true }}
            className="space-y-4 lg:max-w-xs"
          >
            <div className="flex items-center gap-3">
              <div className="w-10 h-10 rounded-lg bg-primary flex items-center justify-center font-bold text-white text-lg">R</div>
              <div>
                <span className="font-poppins font-bold text-xl text-dark-navy tracking-tight">ROHMAN</span>
                <div className="text-[11px] text-gray-text tracking-wider">Percetakan & Fotokopi</div>
              </div>
            </div>
            <p className="text-sm leading-relaxed text-gray-text">
              Solusi percetakan terpercaya dengan kualitas premium. Kami menyediakan layanan cetak lengkap untuk personal, sekolah, dan bisnis Anda.
            </p>
            <div className="flex gap-3 pt-2">
              <a href="#" className="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white hover:shadow-lg hover:shadow-primary/20 transition-all duration-300">
                <Facebook className="w-4 h-4" />
              </a>
              <a href="#" className="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white hover:shadow-lg hover:shadow-primary/20 transition-all duration-300">
                <Twitter className="w-4 h-4" />
              </a>
              <a href="#" className="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white hover:shadow-lg hover:shadow-primary/20 transition-all duration-300">
                <Instagram className="w-4 h-4" />
              </a>
              <a href="#" className="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white hover:shadow-lg hover:shadow-primary/20 transition-all duration-300">
                <Linkedin className="w-4 h-4" />
              </a>
            </div>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.1 }}
            viewport={{ once: true }}
          >
            <h4 className="text-dark-navy font-semibold text-base mb-5 tracking-wide">Our Services</h4>
            <ul className="space-y-3">
              <li><a href="#" className="text-gray-text text-sm hover:text-primary transition-colors duration-200">Percetakan</a></li>
              <li><a href="#" className="text-gray-text text-sm hover:text-primary transition-colors duration-200">Jasa Dokumen</a></li>
              <li><a href="#" className="text-gray-text text-sm hover:text-primary transition-colors duration-200">Desain & Publishing</a></li>
              <li><a href="#" className="text-gray-text text-sm hover:text-primary transition-colors duration-200">Produk Khusus</a></li>
              <li><a href="#" className="text-gray-text text-sm hover:text-primary transition-colors duration-200">Cetak Foto Kanvas</a></li>
              <li><a href="#" className="text-gray-text text-sm hover:text-primary transition-colors duration-200">Cetak Sublimasi</a></li>
            </ul>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.2 }}
            viewport={{ once: true }}
          >
            <h4 className="text-dark-navy font-semibold text-base mb-5 tracking-wide">Quick Links</h4>
            <ul className="space-y-3">
              <li><a href="/" className="text-gray-text text-sm hover:text-primary transition-colors duration-200">Home</a></li>
              <li><a href="#" className="text-gray-text text-sm hover:text-primary transition-colors duration-200">Company</a></li>
              <li><a href="#" className="text-gray-text text-sm hover:text-primary transition-colors duration-200">Blog</a></li>
              <li><a href="#" className="text-gray-text text-sm hover:text-primary transition-colors duration-200">Portfolio</a></li>
              <li><a href="#" className="text-gray-text text-sm hover:text-primary transition-colors duration-200">Shop</a></li>
              <li><a href="#" className="text-gray-text text-sm hover:text-primary transition-colors duration-200">Contacts</a></li>
            </ul>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.3 }}
            viewport={{ once: true }}
            className="space-y-4"
          >
            <h4 className="text-dark-navy font-semibold text-base mb-5 tracking-wide">Contact Us</h4>
            <div className="flex items-center gap-3">
              <div className="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                <MapPin className="w-4 h-4" />
              </div>
              <div>
                <p className="text-sm text-gray-text">Jl. Raya Penerangan No. 11D</p>
                <p className="text-sm text-gray-text">Rawamangun, Jakarta Timur</p>
              </div>
            </div>
            <div className="flex items-center gap-3">
              <div className="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                <Phone className="w-4 h-4" />
              </div>
              <div>
                <p className="text-sm text-gray-text">021-1234-5678</p>
                <p className="text-sm text-gray-text">0812-3456-7890</p>
              </div>
            </div>
            <div className="flex items-center gap-3">
              <div className="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                <Mail className="w-4 h-4" />
              </div>
              <div>
                <p className="text-sm text-gray-text">info@rohman-percetakan.com</p>
              </div>
            </div>
          </motion.div>
        </div>

        <div className="border-t border-border-light my-8" />

        <div className="flex flex-col sm:flex-row items-center justify-between gap-4">
          <motion.p
            initial={{ opacity: 0 }}
            whileInView={{ opacity: 1 }}
            transition={{ duration: 0.6, delay: 0.4 }}
            viewport={{ once: true }}
            className="text-xs text-gray-text"
          >
            © 2026 ROHMAN Percetakan & Fotokopi. All rights reserved.
          </motion.p>
          <motion.a
            initial={{ opacity: 0 }}
            whileInView={{ opacity: 1 }}
            transition={{ duration: 0.6, delay: 0.5 }}
            viewport={{ once: true }}
            href="/login"
            className="text-xs text-gray-text hover:text-primary transition-colors duration-200"
          >
            Admin Area
          </motion.a>
        </div>
      </div>
    </footer>
  );
};

export default Footer;