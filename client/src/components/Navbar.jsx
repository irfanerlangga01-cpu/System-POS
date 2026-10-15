import React, { useState, useEffect } from 'react';
import { Menu, Search, X } from 'lucide-react';

const Navbar = () => {
  const [isScrolled, setIsScrolled] = useState(false);
  const [mobileOpen, setMobileOpen] = useState(false);

  useEffect(() => {
    const handleScroll = () => setIsScrolled(window.scrollY > 50);
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const menuItems = ['Home', 'Company', 'Blog', 'Portfolio', 'Shop', 'Contacts'];

  return (
    <nav className={`sticky top-0 z-50 transition-all duration-300 ${isScrolled ? 'bg-white/95 backdrop-blur-md shadow-md' : 'bg-white shadow-sm'}`}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-[72px]">
          {/* Logo */}
          <div className="flex-shrink-0 flex items-center gap-2">
            <div className="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-lg">R</div>
            <span className="font-poppins font-bold text-xl text-dark-navy tracking-tight">ROHMAN</span>
          </div>

          {/* Desktop Menu */}
          <div className="hidden lg:flex items-center gap-8">
            {menuItems.map((item) => (
              <a
                key={item}
                href={item === 'Home' ? '/' : '#'}
                className="text-sm font-medium text-dark-navy/70 hover:text-primary transition-colors duration-200 relative group"
              >
                {item}
                <span className="absolute -bottom-1 left-0 w-0 h-[2px] bg-primary group-hover:w-full transition-all duration-300" />
              </a>
            ))}
          </div>

          {/* Right Side */}
          <div className="flex items-center gap-3">
            <button className="hidden md:flex items-center justify-center w-9 h-9 rounded-full text-gray-text hover:text-primary hover:bg-blue-50 transition-colors">
              <Search className="w-5 h-5" />
            </button>
            <button className="lg:hidden text-dark-navy" onClick={() => setMobileOpen(!mobileOpen)}>
              {mobileOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
            </button>
            <button className="hidden lg:inline-flex items-center px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 hover:shadow-lg hover:shadow-primary/25 transition-all duration-300">
              Free Consultation
            </button>
          </div>
        </div>

        {/* Mobile Menu */}
        {mobileOpen && (
          <div className="lg:hidden py-4 border-t border-border-light/50">
            <div className="flex flex-col gap-3">
              {menuItems.map((item) => (
                <a key={item} href={item === 'Home' ? '/' : '#'} className="px-4 py-2 text-sm font-medium text-dark-navy/70 hover:text-primary hover:bg-blue-50 rounded-lg">
                  {item}
                </a>
              ))}
              <button className="mt-2 w-full py-2.5 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-colors">
                Free Consultation
              </button>
            </div>
          </div>
        )}
      </div>
    </nav>
  );
};

export default Navbar;