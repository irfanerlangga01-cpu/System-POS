import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { User, Mail, MessageCircle, Send } from 'lucide-react';

const ConsultationSection = () => {
  const [formData, setFormData] = useState({ name: '', email: '', subject: '', message: '' });

  return (
    <section className="py-24 relative overflow-hidden bg-gradient-to-br from-primary/5 via-white to-light-blue/30">
      <div className="absolute inset-0">
        <div className="absolute top-0 right-0 w-1/2 h-full bg-[url('https://images.unsplash.com/photo-1494790108755-2616b612b786?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=800&w=800&q=80')] bg-cover bg-center opacity-15" />
        <div className="absolute inset-0 bg-gradient-to-l from-primary/5 to-transparent" />
      </div>

      <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="text-center mb-14"
        >
          <span className="inline-block text-primary text-xs font-semibold tracking-[0.15em] uppercase mb-3 bg-primary/10 px-4 py-1.5 rounded-full">
            Get In Touch
          </span>
          <h2 className="text-3xl md:text-4xl lg:text-[42px] font-bold text-dark-navy leading-[1.2]">
            Join Us To Get<br />Free Consultations
          </h2>
        </motion.div>

        <div className="grid lg:grid-cols-2 gap-12 items-start max-w-6xl mx-auto">
          {/* Left: Image */}
          <motion.div
            initial={{ opacity: 0, x: -40 }}
            whileInView={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8 }}
            viewport={{ once: true }}
            className="relative order-2 lg:order-1"
          >
            <div className="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
              <img
                src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=600&w=500&q=80"
                alt="Consultation"
                className="w-full h-[500px] object-cover"
              />
            </div>
            <div className="absolute -bottom-6 -right-6 w-32 h-32 bg-primary rounded-2xl shadow-lg flex items-center justify-center text-white font-bold text-2xl -z-10">
              10+
              <span className="text-xs block font-normal">Years Exp.</span>
            </div>
          </motion.div>

          {/* Right: Form */}
          <motion.div
            initial={{ opacity: 0, x: 40 }}
            whileInView={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8 }}
            viewport={{ once: true }}
            className="bg-white rounded-2xl shadow-card p-8 order-1 lg:order-2"
          >
            <form className="space-y-5">
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-medium text-dark-navy/70 mb-2">Full Name *</label>
                  <div className="relative">
                    <User className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-text" />
                    <input
                      type="text"
                      placeholder="Your full name"
                      className="w-full pl-10 pr-4 py-3 border border-border-light rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm"
                      value={formData.name}
                      onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                    />
                  </div>
                </div>
                <div>
                  <label className="block text-sm font-medium text-dark-navy/70 mb-2">Email Address *</label>
                  <div className="relative">
                    <Mail className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-text" />
                    <input
                      type="email"
                      placeholder="you@example.com"
                      className="w-full pl-10 pr-4 py-3 border border-border-light rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm"
                      value={formData.email}
                      onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                    />
                  </div>
                </div>
              </div>
              <div>
                <label className="block text-sm font-medium text-dark-navy/70 mb-2">Subject</label>
                <input
                  type="text"
                  placeholder="Enter subject"
                  className="w-full px-4 py-3 border border-border-light rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm"
                  value={formData.subject}
                  onChange={(e) => setFormData({ ...formData, subject: e.target.value })}
                />
              </div>
              <div>
                <label className="block text-sm font-medium text-dark-navy/70 mb-2">Message *</label>
                <div className="relative">
                  <MessageCircle className="absolute left-3 top-3 w-4 h-4 text-gray-text" />
                  <textarea
                    rows={5}
                    placeholder="Tell us about your project or requirements..."
                    className="w-full pl-10 pr-4 py-3 border border-border-light rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm resize-none"
                    value={formData.message}
                    onChange={(e) => setFormData({ ...formData, message: e.target.value })}
                  />
                </div>
              </div>
              <motion.button
                whileHover={{ scale: 1.02 }}
                whileTap={{ scale: 0.98 }}
                type="submit"
                className="w-full md:w-auto px-8 py-3.5 bg-primary text-white font-semibold text-sm rounded-xl hover:bg-primary-dark hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 flex items-center justify-center gap-2"
              >
                <Send className="w-4 h-4" />
                Send Message
              </motion.button>
            </form>
          </motion.div>
        </div>
      </div>
    </section>
  );
};

export default ConsultationSection;