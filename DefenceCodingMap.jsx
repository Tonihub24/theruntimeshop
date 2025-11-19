import { useState } from "react";
import { motion } from "framer-motion";

const phases = [
  {
    title: "Pre-Production",
    importance: "✨ Critical",
    components: [
      { title: "Runtime Threats", details: ["Detect and mitigate code injection or payload attacks."] }
      // simplified for testing
    ]
  },
  {
    title: "Runtime",
    importance: "⚡ Important",
    components: [
      { title: "Session Management", details: ["Ongoing enforcement of session policies."] }
    ]
  },
];

export default function DefenceCodingMap() {
  const [active, setActive] = useState(null);

  return (
    <div style={{ display: "flex", gap: 16 }}>
      {phases.map((phase, idx) => (
        <div
          key={idx}
          onClick={() => setActive(active === idx ? null : idx)}
          style={{
            border: "1px solid gray",
            padding: 16,
            borderRadius: 12,
            cursor: "pointer",
            width: 250,
          }}
        >
          <h2>{phase.title}</h2>
          <p>{phase.importance}</p>
          {active === idx && (
            <motion.div initial={{ opacity: 0, height: 0 }} animate={{ opacity: 1, height: "auto" }}>
              {phase.components.map((item, i) => (
                <div key={i} style={{ background: "#eee", marginTop: 8, padding: 8, borderRadius: 6 }}>
                  <h3>{item.title}</h3>
                  <ul>
                    {item.details.map((d, j) => (
                      <li key={j}>{d}</li>
                    ))}
                  </ul>
                </div>
              ))}
            </motion.div>
          )}
        </div>
      ))}
    </div>
  );
}
